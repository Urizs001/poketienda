<?php
    include("carrito.php");
    include("config.php");
    include("conexion.php");

$login=curl_init(linkapi."/v1/oauth2/token");
curl_setopt($login,CURLOPT_RETURNTRANSFER,true);
curl_setopt($login,CURLOPT_USERPWD,clientid.":".secret);
curl_setopt($login,CURLOPT_POSTFIELDS,"grant_type=client_credentials");

$respuesta=curl_exec($login);
$objeto=json_decode($respuesta);
$accestoken=$objeto->access_token;

$venta=curl_init(linkapi."/v1/payments/payment/".$_GET['paymentID']);
curl_setopt($venta,CURLOPT_HTTPHEADER,array("Content-Type: application/json","Authorization: Bearer ".$accestoken));
curl_setopt($venta,CURLOPT_RETURNTRANSFER,true);
$respuestaventa=curl_exec($venta);

$objetodatostransaccion=json_decode($respuestaventa);

$state=$objetodatostransaccion->state;
$email=$objetodatostransaccion->payer->payer_info->email;

$total=$objetodatostransaccion->transactions[0]->amount->total;
$currency=$objetodatostransaccion->transactions[0]->amount->currency;
$custom=$objetodatostransaccion->transactions[0]->custom;

$clave=explode("#",$custom);
$ids=$clave[0];
$claveventa=openssl_decrypt($clave[1],cod,key);
curl_close($venta);
curl_close($login);

if($state=="approved"){
    $mensajepaypal="<h3>Pago aprobado</h3>";
    $query=$mysqli->prepare("UPDATE ventas SET paypaldatos = :paypaldatos ,estatus = 'Aprobado'  WHERE id = :id");
    $query->bindParam(":id",$claveventa);
    $query->bindParam(":paypaldatos",$respuestaventa);
    $query->execute();

    
    $query=$mysqli->prepare("UPDATE ventas SET estatus = 'Completo'  WHERE clavetrans = :clavetrans AND total = :total AND id = :id");
    $query->bindParam(":clavetrans",$ids);
    $query->bindParam(":total",$total);
    $query->bindParam(":id",$claveventa);
    $query->execute();

    $_SESSION["sms"]="Pago Aprobado";
    unset($_SESSION['carrito']);
    unset($_SESSION['total']);
    unset($_SESSION['ids']);
    unset($_SESSION['idventa']);
    header("Location: ../index.php?seccion=final");
    exit();

}else{
    $_SESSION["sms"]="Error al realizar el pago..!!";
    header("Location: ../index.php?seccion=final");
    exit();
}
?>
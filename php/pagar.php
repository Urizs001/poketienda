<?php
    include("carrito.php");
    include("config.php");
    include("conexion.php");
    if ($_POST) {
        $total=0;
        $correo=$_POST["email"];
        $ids=session_id();
        foreach ($_SESSION["carrito"] as $indice => $producto){
            $total = $total + ($producto["precio"] * $producto["cantidad"]);
        }
        $query = $mysqli->prepare("INSERT INTO ventas(clavetrans, paypaldatos, fecha, correo, total, estatus) VALUES (:clavetrans, '', NOW(), :correo, :total, 'Pendiente')");
        $query->bindParam(":clavetrans", $ids);
        $query->bindParam(":correo", $correo);
        $query->bindParam(":total", $total);
        $query->execute();
        $idventa=$mysqli->lastInsertId();

        foreach ($_SESSION["carrito"] as $indice => $producto){
            $query = $mysqli->prepare("
            INSERT INTO detalleventa(idventa, idproducto, preciounitario, cantidad) VALUES (:idventa,:idproducto,:preciounitario,:cantidad)");
            $query->bindParam(":idventa", $idventa);
            $query->bindParam(":idproducto",$producto["id"] );
            $query->bindParam(":preciounitario", $producto["id"] );
            $query->bindParam(":cantidad",$producto["cantidad"]);
            $query->execute();
        }
        session_start();
        $_SESSION["total"]=$total;
        $_SESSION["ids"]=$ids;
        $_SESSION["idventa"]=$idventa;
        header("Location: ../index.php?seccion=pago");
        exit();
    }
?>
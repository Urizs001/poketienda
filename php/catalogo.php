<?php 
    $query =$mysqli->prepare("SELECT imgn,nombre,numero,id_pokemon FROM pokemon");
    $query->execute();
    $result=$query->fetchALL(PDO::FETCH_ASSOC);

    foreach ($result as $producto) {
        echo "
        <div class='conten'>
        <img src='". $producto["imgn"] ."' alt=''>
        <figcaption>". $producto["nombre"] ."</figcaption>
        <h3>Precio: $ ". $producto["numero"] ."</h3>
        <form method='POST'>
        <input type='hidden' name='id' id='id' value='".openssl_encrypt($producto["id_pokemon"],cod,key)."'>
        <input type='hidden' name='nombre' id='nombre' value='".openssl_encrypt($producto["nombre"],cod,key)."'>
        <input type='hidden' name='precio' id='precio' value='".openssl_encrypt($producto["numero"],cod,key)."'>
        <input type='hidden' name='cantidad' id='cantidad' value='".openssl_encrypt(1,cod,key)."'>
        <button class='btn-add' value='Agregar' name='btnAdd' ><i class='fa-solid fa-cart-plus'></i></button>
        </form>
        </div>";
    }
?>
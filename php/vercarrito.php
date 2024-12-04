<div class="contenido">
    <?php
    $total = 0;
    if (!empty($_SESSION["carrito"])) {
        echo "
            <h2>Lista del carrito</h2>
            <table class='table'>
                <tbody>
                    <tr>
                        <th width='40%' id='name'>Nombre</th>
                        <th width='15%'>Precio</th>
                        <th width='20%'>Cantidad</th>
                        <th width='20%'>Total</th>
                        <th width='5%'>--</th>
                    </tr>";
                    foreach ($_SESSION["carrito"] as $indice=>$producto) {
                        echo "<tr>
                            <td width='40%'>" . $producto["nombre"] . "</td>
                            <td width='15%' class='center'>" . $producto["precio"] . "</td>
                            <td width='20%' class='center'>" . $producto["cantidad"] . "</td>
                            <td width='20%' class='center'>" . number_format($producto["precio"] * $producto["cantidad"], 2) . "</td>
                            <td width='5%' class='center'> 
                            <form action='' method='POST'>
                                <input type='hidden' name='id' id='id' value='".openssl_encrypt($producto["id"],cod,key)."'>
                                    <button class='btn-add' value='Eliminar' name='btnAdd' ><i class='fa-solid fa-trash'></i></button>
                                </form>
                            </td>
                        </tr>
                        ";
                        $total = $total + ($producto["precio"] * $producto["cantidad"]);
                    }
                    echo "
                    <tr>
                        <td colspan='3' id='total'><h3>Total</h3></td>
                        <td><h3>$" . number_format($total, 2) . "</h3></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan='5'>
                            <form action='php/pagar.php' class='mensaje' method='POST'>
                                <label for='email'>Correo de contacto:</label>
                                <input type='email' name='email' id='email' placeholder='Email de contacto' required>
                                <small>Los productos se enviaran a este correo</small>
                                <button id='brn-principal' name='btnAdd' value='proceder'>Proceder a pagar >></button>
                            </form>
                        </td>
                    </tr>

                </tbody>
            </table>
        ";
    } else {
        echo "<h2>No hay productos en el carrito</h2>";
    }
    ?>
</div>
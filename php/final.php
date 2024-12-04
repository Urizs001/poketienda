<div id="mensajepago">
    <h1>!Listo¡</h1>
    <hr>
    <?php if (isset($_SESSION['sms'])) { echo "<h4>" .$_SESSION['sms']. "</h4>";unset($_SESSION['sms']);;} ?>
    <p>Los pokemones ya son suyos</p>
    <strong>Gracias por su compra!!</strong>
    <a href="index.php?seccion=catalogo">Seguir comprando</a>
</div>

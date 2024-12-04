<?php
include("php/config.php");
include("php/conexion.php");
include("php/carrito.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <script src="https://kit.fontawesome.com/56497fa989.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/secion.css">
    <title>Poketienda</title>
</head>
<body>
    <nav>
    <h1>PokeTienda <i class="fa-solid fa-dragon"></i></h1>
    
    <div class="nav-link">
        <a href="index.php?seccion=catalogo"><i class="fa-solid fa-store"></i></a>
        <a href="index.php?seccion=carrito"><i class="fa-solid fa-cart-shopping"></i> (<?php echo (empty($_SESSION['carrito']))?0:count($_SESSION['carrito']);?>)</a>
        <div class="busqueda">
            <input type="text" name="name" id="pokemonName" placeholder="Buscar...">
            <button onclick="buscar()"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
        <?php if (!empty($_SESSION['nombre'])) : ?>
            <?php include("php/sesion/cerrar.php");?>
            <span id='usu' class="nav-links">
                <?= htmlspecialchars($_SESSION['nombre']) ?>
                <i class='fa-solid fa-user-large'></i>
                <div class="user-menu">
                    <a href="index.php?seccion=perfil">Mis compras</a>
                    <form action="" method="POST">
			            <button type="submit" name="cerrar-sesion" value="1" class="btn-logout">Cerrar sesión</button>
		            </form>
                </div>
            </span>
        <?php else : ?>
            <a href='index.php?seccion=sesion'>Iniciar Sesion <i class='fa-solid fa-user-large'></i></a>
        <?php endif; ?>
    </div>
    </nav>
    <div class="con-sms">
            <?php if($mensaje!=""){ echo "<h3 class='mensaje'>".$mensaje."</h3>";}?>
    </div>
    <main>
        <div class="pokemonInfo" id="pokemonInfo"></div>
        <?php
            if (isset($_GET['seccion'])) {
                $seccion=$_GET['seccion'];
                    switch ($seccion) {
                    case 'catalogo':
                        include_once("php/catalogo.php");
                        break;
                    case 'carrito':
                        include_once("php/vercarrito.php");
                        break;
                    case 'pago':
                        include_once("php/pagofinal.php");
                        break;
                    case 'final':
                        include_once("php/final.php");
                        break;
                    case 'sesion':
                        include_once("php/sesion/sesion.php");
                        break;
                    case 'crearcuenta':
                        include_once("php/sesion/crearcuenta.php");
                        break;
                    default:
                        echo "<h1>Error 404....!</h1>";
                        break;
                }
            }
            else{
                include_once("php/catalogo.php");
            }
        ?>
    </main>
    <footer>Para aclaraciones: poketienda@gmail.com</footer>
    <script src="js/pokedex.js"></script>
</body>
</html>
<?php
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");

	if (!isset($_SESSION["id_usuario"])) {
		header("Location: index.php?seccion=catalogo");
    	exit();
	}
	if (isset($_POST['cerrar-sesion']) && $_POST['cerrar-sesion'] == 1) {
		session_unset();
		session_destroy();
		header("Location: index.php?seccion=catalogo");
		exit();
	}
?>
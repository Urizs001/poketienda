<?php
	header("Cache-Control: no-cache, no-store, must-revalidate");
	header("Pragma: no-cache");
	header("Expires: 0");
	require ('../config.php');
	require ('../conexion.php');

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	    $usuario = $_POST["usuario"];
    	$contraseña = $_POST['password'];

		$query=$mysqli->prepare("SELECT id_usuario, contraseña, tipo, nombre FROM usuario WHERE nombre = :nombre");
	    $query->bindParam(":nombre",$usuario);
		$query->execute();
		$result=$query->fetchALL(PDO::FETCH_ASSOC);
		

	    if ($query && count($result) > 0) {
			foreach($result as $row){
				$hashContraseña = $row['contraseña'];
	        	$tipo=$row['tipo'];
			}

	        if (password_verify($contraseña,$hashContraseña)) {
	            session_start();
				foreach($result as $row){
					$_SESSION["nombre"] = $row['nombre'];
					$_SESSION["id_usuario"] = $row['id_usuario'];
					$_SESSION["tipou"]=$row['tipo'];
				}
	            if (session_status() === PHP_SESSION_ACTIVE) {
					switch($_SESSION["tipou"]){
						case "admin":
							break;
						case "empleado":
							break;
						case "cliente":
							header("Location: ../../index.php");
	            			exit();
						default:
							break;
					}
				}
	        } else {
	        	session_start();
	            $_SESSION['error'] = "El usuario o la contraseña es incorrecta.";
	            header("Location: ../../index.php?seccion=sesion");
	            exit();
	        }
	    } else {
	        session_start();
	        $_SESSION['error'] = "El usuario o la contraseña es incorrecta.";
	        header("Location: ../../index.php?seccion=sesion");
	        exit();
	    }
	}
?>
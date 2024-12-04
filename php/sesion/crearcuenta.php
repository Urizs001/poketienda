<?php 	
	header("Cache-Control: no-cache, no-store, must-revalidate");
	header("Pragma: no-cache");
	header("Expires: 0");

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

	    $usuario = $_POST["usuario"];
	    $contraseña = $_POST["password"];
	    $confirmar_contraseña = $_POST["conpassword"];
		$email=$_POST["email"];
		$celular=$_POST["celular"];

	    if ($contraseña == $confirmar_contraseña) {
	    
	        $hashContraseña = password_hash($contraseña, PASSWORD_BCRYPT);
	        
	        	
	        	try {
					$query=$mysqli->prepare("CALL insertar_usuario(:nombre_param,:contrasena_param,:correo_param,:telefono_param,'cliente',1,null,null,null)");
	        		$query->bindParam(":nombre_param",$usuario);
					$query->bindParam(":contrasena_param",$hashContraseña);
					$query->bindParam(":correo_param",$email);
					$query->bindParam(":telefono_param",$celular);
					$query->execute();

	        		if ($query) {
			            header("Location: index.php?seccion=sesion");
			            exit();
		        	} else {
		            	$error= "Error al registrar el usuario. Por favor, inténtalo nuevamente.";
		        	}

	        	} catch (Exception $e) {
	        		 if ($e->getCode() === 1062) {
        				$error= "El usuario ya existe en la base de datos. Intente con otro";
    				} else {
        				$error= "Las contraseas no coinciden. Por favor, inténtalo nuevamente.";
    				}
	        	}
   				
	    } else {
	        $error= "Las contraseñas no coinciden. Por favor, inténtalo nuevamente.";
	    }
	}
?>

<div id="sesion">
    <form name="login" method="POST" action="">
		<h2>CREAR CUENTA</h2>
		<?php if (isset($error)) { echo "<p class='error'>" . htmlspecialchars($error) . "</p>"; } ?>
		<input type="text" name="usuario" placeholder="Ingresar su usuario" maxlength="10">
		<input type="password" name="password" placeholder="Ingresar su contraseña" maxlength="20">
		<input type="password" name="conpassword" placeholder="Confirme su contraseña" maxlength="20">
		<input type='email' name='email' id="emailid" placeholder='Ingresar su email' autocomplete='off' maxlength='50'>
        <input type="tel" name="celular" placeholder="Ingrese su celular" pattern="[0-9]{10}" maxlength="10">
		<input type="submit" name="registrar" value="Registrar">
		<a href="index.php?seccion=sesion">Ya tengo una cuenta</a>
	</form>
</div>
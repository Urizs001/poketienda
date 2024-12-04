<?php
    session_start();
    $mensaje="";
    if (isset($_POST['btnAdd'])) {
        if (isset($_SESSION["id_usuario"])) {
            switch ($_POST['btnAdd']) {
                case 'Agregar':
                    if (is_numeric(openssl_decrypt($_POST['id'],cod,key))) {
                        $id=openssl_decrypt($_POST['id'],cod,key);
                        $mensaje.="OK id correcto...".$id;
                    }else{
                        $mensaje.="UPS id incorrecto...";
                    }
                    if (openssl_decrypt($_POST['nombre'],cod,key)) {
                        $nombre=openssl_decrypt($_POST['nombre'],cod,key);
                        $mensaje.="OK nombre correcto...".$nombre;
                    }else{
                        $mensaje.="UPS nombre incorrecto...";
                    }
                    if (is_numeric(openssl_decrypt($_POST['precio'],cod,key))) {
                        $precio=openssl_decrypt($_POST['precio'],cod,key);
                        $mensaje.="OK precio correcto...".$precio;
                    }else{
                        $mensaje.="UPS precio incorrecto...";
                    }
                    if (is_numeric(openssl_decrypt($_POST['cantidad'],cod,key))) {
                        $cantidad=openssl_decrypt($_POST['cantidad'],cod,key);
                        $mensaje.="OK cantidad correcto...".$cantidad;
                    }else{
                        $mensaje.="UPS cantidad incorrecto...";
                    }
                    if (!isset($_SESSION['carrito'])) {
                        $producto=array(
                            'id' =>$id,
                            'nombre' =>$nombre,
                            'precio' =>$precio,
                            'cantidad' =>$cantidad
                        );
                        $_SESSION['carrito'][0]=$producto;
                        $mensaje="Producto agregado a su carrito...";
                    }else{
                        $id_productos=array_column($_SESSION["carrito"],"id");
                        if (in_array($id,$id_productos)) {
                            $mensaje="Este producto ya fue añadido su carrito...";
                        }else{
                            $numproductos=count($_SESSION['carrito']);
                            $producto=array(
                                'id' =>$id,
                                'nombre' =>$nombre,
                                'precio' =>$precio,
                                'cantidad' =>$cantidad
                            );
                            $_SESSION['carrito'][$numproductos]=$producto;
                            $mensaje="Producto agregado a su carrito...";
                        }
                    }
                    
    
                    break;
                case 'Eliminar':
                    if (is_numeric(openssl_decrypt($_POST['id'],cod,key))) {
                        $id=openssl_decrypt($_POST['id'],cod,key);
                        foreach ($_SESSION["carrito"] as $indice => $producto) {
                            if ($producto["id"]==$id) {
                                unset($_SESSION["carrito"][$indice]);
                            }
                        }
                    }else{
                        $mensaje.="UPS id incorrecto...";
                    }
                    break;
                default:
                    # code...
                    break;
            }
        }else{
            $_SESSION["sms"]="Para agregar productos al carrito usted deve iniciar sesion primero";
            header("Location: index.php?seccion=sesion");
            exit();
        }
    }
?>
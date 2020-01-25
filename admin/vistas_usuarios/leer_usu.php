<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro</title>
    <link rel="icon" type="image/png" href="logo.png">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <style type="text/css">
        .colorgraph {
            height: 5px;
            border-top: 0;
            background: #c4e17f;
            border-radius: 5px;
            background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
            background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
            background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
            background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
        }
    </style>
</head>
<?php
// Incluimos el controlador a los objetos a usar
require_once $_SERVER['DOCUMENT_ROOT']."/musihub/dirs.php";
require_once CONTROLLER_PATH."ControladorUsuario.php";
require_once UTILITY_PATH."funciones.php";
session_start();
if(isset($_SESSION['USUARIO']['email'])){
    if($_SESSION['administrador'] == "si"){
// Compramos la existencia del parámetro id antes de usarlo
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Cargamos el controlador de coches
    $id = decode($_GET["id"]);
    $controlador = ControladorUsuario::getControlador();
    $usuario= $controlador->buscarUsuario($id);
    if (is_null($usuario)){
        // hay un error
        header("location: error.php");
        exit();
    } 
}
?>

<!-- Cabecera de la página web -->
<?php //require_once VIEW_PATH."cabecera.php"; ?>

<!-- Cuerpo de la página web -->
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                    <h1>Información de Usuario</h1>
                    <hr class="colorgraph">
                <table>
                    <tr>
                        <td class="col-xs-11" class="align-top">
                            <div class="form-group">
                                <!-- Muestro los datos del usuario-->
                                <div class="form-group">
                                    <label><big>Nombre</big></label>
                                    <p class="form-control-static"><?php echo $usuario->getnombre(); ?></p>
                                </div>
                        </td>                        
                        <td class="align-left">
                            <img src='<?php echo "../../imagenes/fotos/" . $usuario->getfoto() ?>' class='rounded' class='img-thumbnail' width='150' height='auto'>
                        </td>
                    </tr>
                </table>
                <br>
                    <label>Apellidos</label>
                                    <p class="form-control-static"><?php echo $usuario->getapellidos(); ?></p>
                                    <br>
                    <div class="form-group">
                        <label>Correo Electrónico</label>
                        <p class="form-control-static"><?php echo $usuario->getemail(); ?></p>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>Contraseña</label>
                            <p class="form-control-static"><?php echo str_repeat("*",strlen($usuario->getpassword())); ?></p>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>Administrador</label>
                            <p class="form-control-static"><?php echo $usuario->getadministrador(); ?></p>
                    </div>
                    
                    <br>
<div class="form-group">
                        <label>Telefono</label>
                            <p class="form-control-static"><?php echo $usuario->gettelefono(); ?></p>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>Fecha de Alta</label>
                            <p class="form-control-static"><?php echo $usuario->getfecha_alta(); ?></p>
                    </div>
                    <hr class="colorgraph">
                    <div class="col-xs-12 col-md-6"><a href="../vistas_usuarios/listado_usu.php" class="btn btn-primary btn-block btn-lg"> Aceptar</a>
                </div>
            </div>        
        </div>
    </div>
<br><br><br>
<?php
}else{
    header("location:/musihub/error403.php");
}
}else{
    header("location:/musihub/error403.php");
}
?>
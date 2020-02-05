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
// Iniciamos la sesion
session_start();
// Incluimos el controlador a los objetos a usar
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once CONTROLLER_PATH . "ControladorUsuario.php";
require_once CONTROLLER_PATH . "ControladorImagen.php";
require_once UTILITY_PATH . "funciones.php";
//Comprobamos que existe la sesion 
if (isset($_SESSION['USUARIO']['email'])) {
    //Comprobamos si es administrador o no y si lo es puede continuar en el caso de que no lo sea lo llevara a una página de error
    if ($_SESSION['administrador'] == "si") {
        // Cogemos la ID del usuario para buscarlo en la base de datos mediante la funcion buscarUsuario
        if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
            $id = decode($_GET["id"]);
            $controlador = ControladorUsuario::getControlador();
            $usuario = $controlador->buscarUsuario($id);
            if (is_null($usuario)) {
                // Si el usuario no existe nos llevara a una página de error
                header("location: error.php");
                exit();
            }
        }

        // Los datos del formulario al procesar el sí.
        if (isset($_POST["id"]) && !empty($_POST["id"])) {
            $controlador = ControladorUsuario::getControlador();
            $usuario = $controlador->buscarUsuario($_POST["id"]);
            if ($controlador->borrarUsuario($_POST["id"])) {

                $controlador = ControladorImagen::getControlador();
                if ($controlador->eliminarFoto($usuario->getfoto())) {
                    header("location: listado_usu.php");
                    exit();
                } else {
                    header("location: error.php");
                    exit();
                }
            } else {
                header("location: error.php");
                exit();
            }
        }

?>
        <!-- Cabecera de la página web -->
        <?php //require_once VIEW_PATH."cabecera.php"; 
        ?>
        <!-- Cuerpo de la página web -->
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                    <h1>
                        <center>Borrar Usuario</center>
                    </h1>
                    <hr class="colorgraph">
                    <table>
                        <tr>
                            <td>
                                <div>
                                    <!-- Muestro los datos del usuario-->
                                    <div>
                                        <label>Nombre</label>
                                        <p><?php echo $usuario->getnombre(); ?></p>
                                    </div>
                            </td>
                            <td style="position:absolute; left:400px;">
                                <img src='<?php echo "../../imagenes/fotos/" . $usuario->getfoto() ?>' class='rounded' class='img-thumbnail' width='150' height='auto'>
                            </td>
                        </tr>
                    </table>
                    <div>
                        <label>Apellidos</label>
                        <p><?php echo $usuario->getapellidos(); ?></p>
                    </div>

                    <div>
                        <label>Correo Electrónico</label>
                        <p><?php echo $usuario->getemail(); ?></p>
                    </div>
                    <div>
                        <label>Contraseña</label>
                        <p><?php echo str_repeat("*", strlen($usuario->getpassword())); ?></p>
                    </div>
                    <div>
                        <label>Administrador</label>
                        <p><?php echo $usuario->getadministrador(); ?></p>
                    </div>


                    <div>
                        <label>Telefono</label>
                        <p><?php echo $usuario->gettelefono(); ?></p>
                    </div>
                    <div>
                        <label>Fecha de Alta</label>
                        <p><?php echo $usuario->getfecha_alta(); ?></p>
                    </div>
                    <hr class="colorgraph">


                    <!-- Procesamos el formulario en la misma página -->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="id" value="<?php echo trim($id); ?>" />
                            <p>¿Está seguro que desea borrar este usuario?</p><br>
                            <p>
                                <button type="submit" class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span> Borrar</button>
                                <a href="listado_usu.php" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
        <br><br><br>

        <!-- Pie de la página web -->
        <?php //require_once VIEW_PATH."pie.php"; 
        ?>
<?php
// En caso de que no este logeado o no sea administrador les redireccionara a la pagina de error403
    } else {
        header("location:/musihub/error403.php");
    }
} else {
    header("location:/musihub/error403.php");
}
?>
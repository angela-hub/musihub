<?php
// Incluimos el controlador a los objetos a usar
require_once $_SERVER['DOCUMENT_ROOT']."/musihub/dirs.php";
require_once CONTROLLER_PATH."ControladorUsuario.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";

// Obtenemos los datos del coche que nos vienen de la página anterior
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = decode($_GET["id"]);
    $controlador = ControladorUsuario::getControlador();
    $usuario = $controlador->buscarUsuario($id);
    if (is_null($usuario)) {
        // hay un error
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
       if($controlador->eliminarFoto($usuario->getfoto())){
            header("location: ../index.php");
            exit();
       }else{
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
<?php //require_once VIEW_PATH."cabecera.php"; ?>
<!-- Cuerpo de la página web -->
<div class="wrapper">
    <div class="container-fluid">
    <title>Borrar Usuario</title>
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h1>Borrar Usuario</h1>
                </div>
                <table>
                    <tr>
                        <td class="col-xs-11" class="align-top">
                            <div class="form-group">
                                <!-- Muestro los datos del usuario-->
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <p class="form-control-static"><?php echo $usuario->getnombre(); ?></p>
                                </div>
                        </td>
                        <td class="col-xs-11" class="align-top">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Apellidos</label>
                                    <p class="form-control-static"><?php echo $usuario->getapellidos(); ?></p>
                                </div>
                        </td>
                        <td class="align-left">
                            <label>Imagen</label><br>
                            <img src='<?php echo "../../imagenes/fotos/" . $usuario->getfoto() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
                        </td>
                    </tr>
                </table>
                    <div class="form-group">
                        <label>Correo Electrónico</label>
                        <p class="form-control-static"><?php echo $usuario->getemail(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Contraseña</label>
                            <p class="form-control-static"><?php echo str_repeat("*",strlen($usuario->getpassword())); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Administrador</label>
                            <p class="form-control-static"><?php echo $usuario->getadministrador(); ?></p>
                    </div>
                    

<div class="form-group">
                        <label>Telefono</label>
                            <p class="form-control-static"><?php echo $usuario->gettelefono(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Fecha de Alta</label>
                            <p class="form-control-static"><?php echo $usuario->getfecha_alta(); ?></p>
                    </div>
                <!-- Me llamo a mi mismo pero pasando GET -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="alert alert-danger fade in">
                        <input type="hidden" name="id" value="<?php echo trim($id); ?>"/>
                        <p>¿Está seguro que desea borrar este usuario?</p><br>
                        <p>
                            <button type="submit" class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span>  Borrar</button>
                            <a href="../../index.php" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>        
    </div>
</div>
<br><br><br>

<!-- Pie de la página web -->
<?php //require_once VIEW_PATH."pie.php"; ?>

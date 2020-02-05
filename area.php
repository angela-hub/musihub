<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once CONTROLLER_PATH . "ControladorUsuario.php";
require_once CONTROLLER_PATH . "ControladorImagen.php";
require_once UTILITY_PATH . "funciones.php";
$test=$_SERVER["REQUEST_URI"];
$prueba=encode($_SESSION['id']);
if ($test=="/musihub/area.php?id=$prueba"){

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mi usuario</title>
    <link rel="icon" type="image/png" href="logo.png">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!---------------------------------------- Estilo a la pagina de area ------------------------------------->

    <style type="text/css">
    
        .width30 {
            width: 30%;
        }

        .width70 {
            width: 70%;
        }

        .floatL {
            float: left;
        }

        .width50 {
            width: 50%;
        }

        .floatR {
            float: right;
        }

        .btn {
            width: 100%;
            border-radius: 0px;
        }

        .width100 {
            width: 100%;
        }

        .row {
            margin-left: -20px;
            margin-right: -20px;

        }

        .boxStyle {
            padding: 20px;
            border-radius: 25px;
            border-top: 6px solid #dc3545;
            border-bottom: 6px solid #28a745;
        }
    </style>
</head>
<?php

//if(isset($_SESSION['USUARIO']['email'])){
//if($_SESSION['administrador'] == "si"){

$nombre = $apellidos = $email = $password = $administrador = $telefono = $fecha_alta = $foto = "";
$nombreErr = $apellidosErr = $emailErr = $passwordErr = $administradorErr = $telefonoErr = $fecha_altaErr = $fotoErr = "";
$fotoanterior = "";

if (isset($_POST["id"]) && !empty($_POST["id"])) {
    //ID del usuario logueado
    $id = $_POST["id"];

    // Procesamos el nombre
    $nombreVal = filtrado(($_POST["nombre"]));
    if (empty($nombreVal)) {
        $nombreErr = "Por favor introduzca un nombre válido con solo carávteres alfabéticos.";
    } elseif (!preg_match("/([^\s][A-zÀ-ž\s]+$)/", $nombreVal)) {
        $nombreErr = "Por favor introduzca un nombre válido con solo carávteres alfabéticos.";
    } else {
        $nombre = $nombreVal;
    }

    // Procesamos los apellidos
    $apellidosVal = filtrado(($_POST["apellidos"]));
    if (empty($apellidosVal)) {
        $apellidosErr = "Por favor introduzca unos apellidos válidos.";
    } elseif (!preg_match("/([^\s][A-zÀ-ž\s]+$)/", $nombreVal)) {
        $apellidosErr = "Por favor introduzca unos apellidos válidos.";
    } else {
        $apellidos = $apellidosVal;
    }

    // Procesamos el email
    $emailVal = filtrado($_POST["email"]);
    $controlador = ControladorUsuario::getControlador();
    $usuario = $controlador->buscarusuario($id);
    $emailviejo =  $controlador->buscarUsuarioE($_POST["id"]);
    if (empty($emailVal)) {
        $emailErr = "Por favor introduzca email válido.";
    } elseif($emailVal==$emailviejo) {
        $email = $emailVal;
    } else{
        $usuario = $controlador->buscarUsuarioEmail($emailVal);
        if(isset($usuario)){
            $emailErr = "Ya existe un usuario diferente a ti con email: " .$emailVal. " en la Base de Datos";
        }else{
            $email= $emailVal;
        }
    }
    //password
    $passwordVal = filtrado($_POST["password"]);
    if (empty($passwordVal)) {
        $controlador = ControladorUsuario::getControlador();
        $usuario = $controlador->buscarusuario($id);
        $password = $usuario->getpassword();
    }elseif(strlen($passwordVal) < 5){
        $passwordErr="La contraseña debe tener mas de 4 caracteres";
    }else {
        $password= hash('md5',$passwordVal);
    }

    // Procesamos matrícula
    if (isset($_POST["matricula"])) {
        $matricula = filtrado($_POST["matricula"]);
    } else {
        $matriculaErr = "Debe elegir al menos una matricula";
    }

    // Procesamos el tipo de usuario
    if (isset($_POST["administrador"])) {
        $administrador = filtrado($_POST["administrador"]);
    } else {
        $administradorErr = "Debe elegir el tipo de usuario que es";
    }

    // Procesamos el teléfono
    $telefonoVal = filtrado($_POST["telefono"]);
    if (empty($telefonoVal)) {
        $telefonoErr = "Por favor Introduzca un telefono válido";
    } elseif (!filter_var($telefonoVal, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[0-9]{9}/")))) {
        $telefonoErr = "Por favor intruduzca un teléfono válida con el formato NNNNNNNNN";
    } else {
        $telefono = $telefonoVal;
    }
    // Procesamos fecha
    $fecha_alta = date("d-m-Y", strtotime(filtrado($_POST["fecha_alta"])));

    if ($_FILES['foto']['size'] > 0 && count($errores) == 0) {
        $propiedades = explode("/", $_FILES['foto']['type']);
        $extension = $propiedades[1];
        $mod = true;
        // Si no coicide la extensión
        if ($extension != "jpg" && $extension != "jpeg") {
            $mod = false;
            $fotoErr = "Formato debe ser jpg/jpeg";
        }

        // Si todo es correcto, mod = true
        if ($mod) {
            // salvamos la imagen
            $foto = md5($_FILES['foto']['tmp_name'] . $_FILES['foto']['name'] . time()) . "." . $extension;
            $controlador = ControladorImagen::getControlador();
            if (!$controlador->salvarImagen($foto)) {
                $fotoErr = "Error al procesar la imagen y subirla al servidor";
            }

            // Borramos la antigua
            $fotoAnterior = trim($_POST["fotoAnterior"]);
            if ($fotoAnterior != $foto) {
                if (!$controlador->eliminarImagen($fotoAnterior)) {
                    $fotoErr = "Error al borrar la antigua imagen en el servidor";
                }
            }
        } else {
            // Si no la hemos modificado
            $foto = trim($_POST["fotoAnterior"]);
        }
    } else {
        $foto = trim($_POST["fotoAnterior"]);
    }
    if (
        empty($nombreErr) && empty($apellidosErr) && empty($emailErr) && empty($passwordErr) && empty($administradorErr) && empty($telefonoErr)
        && empty($fecha_altaErr) && empty($fotoErr)
    ) {
        $controlador = ControladorUsuario::getControlador();
        $estado = $controlador->actualizarUsuarioN($id, $nombre, $apellidos, $email, $password, $telefono, $foto);

        if ($estado) {
            header("location: /musihub/index.php");
            exit();
        } else {
            alerta("No se a podido enviar la solicitud");
            exit();
        }
    } else {
        alerta("Hay errores al enviar la solicitud reviselos");
    }
}
// Chequeamos los errores antes de insertar en la base de datos
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id =  decode($_GET["id"]);
    $controlador = ControladorUsuario::getControlador();
    $usuario = $controlador->buscarusuario($id);
    if (!is_null($usuario)) {
        $nombre = $usuario->getnombre();
        $apellidos = $usuario->getapellidos();
        $email = $usuario->getemail();
        $password = $usuario->getpassword();
        $administrador = $usuario->getadministrador();
        $telefono = $usuario->gettelefono();
        $fecha_alta = $usuario->getfecha_alta();
        $foto = $usuario->getfoto();
        $fotoAnterior = $foto;
    } else {
        // hay un error
        header("location: errors.php");
        exit();
    }
} else {
    // hay un error
    header("location: error.php");
    exit();
}
?>

<!---------------------------------------- Formulario de area ------------------------------------->


<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">

    <body class="bg-dark">
        <header class="bg-dark" style="height: 60px; padding: 5px;">
            <h3 class="text-light" style="text-align: center;">Mi ficha</h3>
        </header>
        <div class="container bg-dark">
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-2"></div>
                <div class="col-sm-6 bg-light boxStyle">
                    <form name="theform" action="" onSubmit="validate()">
                        <!-- Fotografia-->
                        <img src='<?php echo "imagenes/fotos/" . $usuario->getfoto() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="hidden" name="fotoAnterior" value="<?php echo $fotoAnterior; ?>" />
                        <!-- Nombre-->
                        <div class="form-group">
                            <div <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>>
                                <div class="width30 floatL"><label>Nombre</label></div>
                                <div class="width70 floatR"><input class="width100 form-control" type="text" name="nombre" size="50" value="<?php echo $nombre; ?>">
                                    <?php echo $nombreErr; ?>
                                </div>
                            </div><br><br><br>
                            <!-- Apellidos-->
                            <div class="form-group">
                                <div <?php echo (!empty($apellidosErr)) ? 'error: ' : ''; ?>>
                                    <div class="width30 floatL"><label>Apellidos</label></div>
                                    <div class="width70 floatR"><input class="width100 form-control" type="text" name="apellidos" size="50" value="<?php echo $apellidos; ?>">
                                        <?php echo $apellidosErr; ?>
                                    </div>
                                </div>
                            </div><br><br>
                            <!-- Email-->
                            <div class="form-group">
                                <div <?php echo (!empty($emailErr)) ? 'error: ' : ''; ?>>
                                    <div class="width30 floatL"><label>E-mail</label></div>
                                    <div class="width70 floatR"><input class="width100 form-control" type="email" required name="email" value="<?php echo $email; ?>"></div>
                                    <?php echo $emailErr; ?>
                                </div>
                            </div><br><br>
                            <!-- Password -->
                            <div class="form-group">
                                <div <?php echo (!empty($passwordErr)) ? 'error: ' : ''; ?>>
                                    <div class="width30 floatL"><label>Password</label></div>
                                    <div class="width70 floatR"><input class="width100 form-control" placeholder="Si no la modificas se quedara la actual" type="password" name="password"></div>
                                    <?php echo $passwordErr; ?>
                                </div>
                            </div><br><br>
                            <!-- Telefono -->
                            <div class="form-group">
                                <div <?php echo (!empty($telefonoErr)) ? 'error: ' : ''; ?>>
                                    <div class="width30 floatL"><label>Telefono</label></div>
                                    <div class="width70 floatR"><input class="width100 form-control" type="tel" name="telefono" value="<?php echo $telefono; ?>"></div>
                                    <?php echo $telefonoErr; ?>
                                </div>
                            </div>
                            <input type="hidden" name="administrador" value="si" <?php echo (strstr($administrador, 'si')) ? 'checked' : ''; ?>></input>
                            <input type="hidden" name="administrador" value="no" <?php echo (strstr($administrador, 'no')) ? 'checked' : ''; ?>></input><br>
                            <input type="hidden" required name="fecha_alta" value="<?php echo date('Y-m-d', strtotime($fecha_alta)) ?>">
                            <!-- Foto-->
                            <div class="form-group">
                                <div class="form-group <?php echo (!empty($fotoErr)) ? 'error: ' : ''; ?>">
                                    <div class="width30 floatL"><label>Fotografía</label></div>
                                    <!-- Solo acepto imagenes jpg -->
                                    <div class="width70 floatR"><input type="file" name="foto" class="form-control-file" id="foto" accept="image/jpeg"></div>
                                    <span class="help-block"><?php echo $fotoErr; ?></span>
                                </div>
                            </div>
                            <br>
                            <center>
                                <p><div class="width50"><input class="btn btn-success" type="submit" value="Cambiar" style="font-weight: bold"></div></p>
                                <p><div class="width50"><input class="btn btn-danger" type="reset" style="font-weight: bold"></div></p>
                                <a href="index.php"> Volver</a>
                            </center>
                    </form>
                </div>
                <div class="col-sm-1"></div>
                <div class="col-sm-2"></div>
            </div>
        </div>
    </body>
</form>
<br><br><br>
<?php
//}else{
//    header("location:/musihub/error403.php");
//}
//}else{
//    header("location:/musihub/error403.php");
//}
}else{
    header("location:/musihub/error403.php");
}
?>
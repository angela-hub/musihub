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

<body>
    <?php
    session_start();

    // Incluimos los directorios a trabajar
    require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
    require_once CONTROLLER_PATH . "ControladorUsuario.php";
    require_once CONTROLLER_PATH . "ControladorImagen.php";
    require_once UTILITY_PATH . "funciones.php";
    

    $nombre = $apellidos = $email = $password = $telefono = $foto = "";
    $nombreErr = $apellidosErr = $emailErr = $passwordErr = $telefonoErr = $fotoErr = "";
 // Procesamos el formulario al pulsar el botón aceptar de esta ficha
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["aceptar"]){

    // Procesamos el nombre
    $nombreVal = filtrado(($_POST["nombre"]));
    if(empty($nombreVal)){
        $nombreErr = "Por favor introduzca un nombre válido con solo carávteres alfabéticos.";
    } elseif(!preg_match("/([^\s][A-zÀ-ž\s]+$)/", $nombreVal)) { //filter_var($nombreVal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([^\s][A-zÀ-ž\s]+$)/")))){
        $nombreErr = "Por favor introduzca un nombre válido con solo carávteres alfabéticos.";
    } else{
        $nombre= $nombreVal;
    }

    // Procesamos los apellidos
    $apellidosVal = filtrado(($_POST["apellidos"]));
    if(empty($apellidosVal)){
        $apellidosErr = "Por favor introduzca unos apellidos válidos.";
    } elseif(!preg_match("/([^\s][A-zÀ-ž\s]+$)/", $nombreVal)) { //filter_var($nombreVal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([^\s][A-zÀ-ž\s]+$)/")))){
        $apellidosErr = "Por favor introduzca unos apellidos válidos.";
    } else{
        $apellidos= $apellidosVal;
    }

    // Procesamos el email
    $emailVal = filtrado($_POST["email"]);
    if(empty($emailVal)){
        $emailErr = "Por favor introduzca email válido.";
    } else{
        $email= $emailVal;
    }

     // Buscamos que no exista el usuario por el email
     $controlador = ControladorUsuario::getControlador();
     $usuario = $controlador->buscarUsuarioEmail($emailVal);
    if(isset($usuario)){
        $emailErr = "Ya existe un alumno con email:" .$emailVal. " en la Base de Datos";
    }else{
        $email= $emailVal;
    }

    // Procesamos el password
    $passwordVal = filtrado($_POST["password"]);
    if(empty($passwordVal) || strlen($passwordVal)<5){
        $passwordErr = "Por favor introduzca password válido y que sea mayor que 5 caracteres.";
    } else{
        $password= hash('md5',$passwordVal);
    }

    // Procesamos matrícula
    if(isset($_POST["matricula"])){
        $matricula = filtrado($_POST["matricula"]);
    }else{
        $matriculaErr = "Debe elegir al menos una matricula";
    }
    
    // Procesamos el tipo de usuario
    if(isset($_POST["administrador"])){
        $administrador = filtrado($_POST["administrador"]);
    }else{
        $administradorErr = "Debe elegir el tipo de usuario que es";
    }

    // Procesamos el teléfono
    $telefonoVal= filtrado($_POST["telefono"]);
    if(empty($telefonoVal)){
        $telefonoErr="Por favor Introduzca un telefono válido";
    }elseif(!filter_var($telefonoVal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/[0-9]{9}/")))){
        $telefonoErr="Por favor intruduzca un teléfono válida con el formato NNNNNNNNN";
    }else{
        $telefono=$telefonoVal;
    }

    // Cogemos la fecha
    $fecha_alta=date("d-m-Y");

    // Procesamos la foto
    $propiedades = explode("/", $_FILES['foto']['type']);
    $extension = $propiedades[1];
    $mod = true; // Si vamos a modificar

    // Si no coicide la extensión
    if($extension != "jpg" && $extension != "jpeg"){
        $mod = false;
        $fotoErr= "Formato debe ser jpg/jpeg";
    }

    if($mod){
        // salvamos la foto
        $foto = md5($_FILES['foto']['tmp_name'] . $_FILES['foto']['name'].time()) . "." . $extension;
        $controlador = ControladorImagen::getControlador();
        if(!$controlador->salvarImagen($foto)){
            $fotoErr= "Error al procesar la foto y subirla al servidor";
        }
    }
   // Chequeamos los errores antes de insertar en la base de datos
    if(empty($nombreErr) && empty($apellidosErr) && empty($emailErr) && empty($passwordErr) && 
     empty($telefonoErr) && empty($fotoErr)){
        $controlador = ControladorUsuario::getControlador();
        $estado = $controlador->almacenarUsuario($nombre, $apellidos, $email, $password, "" , $telefono, "" ,$foto);
        if($estado){
            header("location: index.php");
            exit();
        }else{
            header("location: error403.php");
            exit();
        }
    }else{
        alerta("Hay errores al procesar el formulario revise los errores");
    }
}
    ?>
    <div class="container">

        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <h2>Registrate <small>Ten un acceso rapido a nuestra web</small></h2>
                    <hr class="colorgraph">

                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6" <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>">
                            <div class="form-group">
                                <input type="text" required name="nombre" class="form-control input-lg" placeholder="Nombre" tabindex="1" value="<?php echo $nombre; ?>">
                                <span class="help-block"><?php echo $nombreErr; ?></span>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-6" <?php echo (!empty($apellidosErr)) ? 'error: ' : ''; ?>">
                            <div class="form-group">
                                <input type="text" required name="apellidos" class="form-control input-lg" placeholder="Apellidos" tabindex="2" value="<?php echo $apellidos; ?>">
                                <span class="help-block"><?php echo $apellidosErr; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6" <?php echo (!empty($emailErr)) ? 'error: ' : ''; ?>">
                        <input type="email" required name="email" class="form-control input-lg" placeholder="E-mail" tabindex="3" value="<?php echo $email; ?>">
                        <span class="help-block"><?php echo $emailErr; ?></span>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6" <?php echo (!empty($passwordErr)) ? 'error: ' : ''; ?>">
                        <input type="password" required name="password" class="form-control input-lg" placeholder="Contraseña" tabindex="4">
                        <span class="help-block"><?php echo $passwordErr; ?></span>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6" <?php echo (!empty($telefonoErr)) ? 'error: ' : ''; ?>">
                            <input type="tel" required name="telefono" class="form-control input-lg" placeholder="Telefono" tabindex="5" value="<?php echo $telefono; ?>" pattern="[0-9]{9}" title="Debes poner 9 números">
                            <span class="help-block"><?php echo $telefonoErr; ?></span>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-6" <?php echo (!empty($fotoErr)) ? 'error: ' : ''; ?>">
                            <input class="form-control input-lg" type="file" required name="foto" class="form-control-file" id="foto" accept="image/jpeg">
                            <span class="help-block"><?php echo $fotoErr; ?></span>
                        </div>
                    </div>
                    <hr class="colorgraph">
                    <div class="row">
                        <div class="col-xs-12 col-md-6"><input type="submit" name="aceptar" value="aceptar" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
                        <div class="col-xs-12 col-md-6"><a href="login.php" class="btn btn-success btn-block btn-lg">Login</a></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
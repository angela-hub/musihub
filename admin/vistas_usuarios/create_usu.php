<?php
//error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
/*session_start();
if(!isset($_SESSION['USUARIO']['email'])){
    //echo $_SESSION['USUARIO']['email'];
    //exit();
    header("location: login.php");
    exit();
}
*/
// Incluimos el controlador a los objetos a usar
//require_once "../dirs.php";

// Incluimos los directorios a trabajar
require_once $_SERVER['DOCUMENT_ROOT']."/musihub/dirs.php";
require_once CONTROLLER_PATH."ControladorUsuario.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";

 
// Variables temporales
$nombre = $apellidos = $email = $password = $administrador = $telefono = $fecha_alta = $foto ="";
$nombreErr = $apellidosErr = $emailErr = $passwordErr = $administradorErr = $telefonoErr = $fecha_altaErr = $fotoErr ="";

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
    $fecha_alta=date("d/m/o");

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
        empty($administradorErr) && empty($telefonoErr) && empty($fecha_altaErr) && empty($fotoErr)){
        $controlador = ControladorUsuario::getControlador();
        $estado = $controlador->almacenarUsuario($nombre, $apellidos, $email, $password, $administrador, $telefono, $fecha_alta, $foto);
        if($estado){
            header("location: ../../index.php");
            exit();
        }else{
            header("location: error.php");
            exit();
        }
    }else{
        alerta("Hay errores al procesar el formulario revise los errores");
    }

}else{
    $fecha = date("Y-m-d");
}
?>
 
<!-- Cabecera de la página web -->
<?php //require_once VIEW_PATH."cabecera.php"; ?>
<!-- Cuerpo de la página web -->
    <div class="wrapper">
    <title>Crear Usuario</title>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Crear Usuario/a</h2>
                    </div>
                    <p>Por favor rellene este formulario para añadir un nuevo usuario/a a la base de datos.</p>
                    <!-- Formulario-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                     <!-- Nombre-->
                        <div class="form-group <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>">
                            <label>Nombre</label>
                            <input type="text" required name="nombre" class="form-control" value="<?php echo $nombre; ?>">
                            <span class="help-block"><?php echo $nombreErr;?></span>
                        </div>
                        <!-- Apellidos-->
                        <div class="form-group <?php echo (!empty($apellidosErr)) ? 'error: ' : ''; ?>">
                            <label>Apellidos</label>
                            <input type="text" required name="apellidos" class="form-control" value="<?php echo $apellidos; ?>">
                            <span class="help-block"><?php echo $apellidosErr;?></span>
                        </div>
                        <!-- Email -->
                        <div class="form-group <?php echo (!empty($emailErr)) ? 'error: ' : ''; ?>">
                            <label>E-Mail</label>
                            <input type="email" required name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $emailErr;?></span>
                        </div>

                        <!-- Password -->
                        <div class="form-group <?php echo (!empty($passwordErr)) ? 'error: ' : ''; ?>">
                            <label>Contraseña</label>
                            <input type="password" required name="password" class="form-control">
                            <span class="help-block"><?php echo $passwordErr;?></span>
                        </div>

                        <!-- Tipo de Usuario -->
                        <div class="form-group <?php echo (!empty($administradorErr)) ? 'error: ' : ''; ?>">
                            <label>Administrador</label>
                            <input type="radio" name="administrador" value="si" <?php echo (strstr($administrador, 'si')) ? 'checked' : ''; ?>>Si</input>
                            <input type="radio" name="administrador" value="no" checked <?php echo (strstr($administrador, 'no')) ? 'checked' : ''; ?>>No</input><br>
                            <span class="help-block"><?php echo $administradorErr;?></span>
                        </div>
                        <!-- Telefono-->
                        <div class="form-group <?php echo (!empty($telefonoErr)) ? 'error: ' : ''; ?>">
                            <label>Telefono</label>
                            <input type="tel" required name="telefono" value="<?php echo $telefono; ?>"
                            pattern="[0-9]{9}" title="Debes poner 9 números">
                            <span class="help-block"><?php echo $telefonoErr;?></span>
                        </div>
                         <!-- Foto-->
                         <div class="form-group <?php echo (!empty($fotoErr)) ? 'error: ' : ''; ?>">
                            <label>Fotografía</label>
                            <input type="file" required name="foto" class="form-control-file" id="foto" accept="image/jpeg">    
                            <span class="help-block"><?php echo $fotoErr;?></span>    
                        </div>
                        <!-- Botones --> 
                         <button type="submit" name= "aceptar" value="aceptar" class="btn btn-success"> <span class="glyphicon glyphicon-floppy-save"></span>  Aceptar</button>
                         <button type="reset" value="reset" class="btn btn-info"> <span class="glyphicon glyphicon-repeat"></span>  Limpiar</button>
                        <a href="../../index.php" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
<br><br><br>
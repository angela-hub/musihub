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
session_start();
if(isset($_SESSION['USUARIO']['email'])){
    if($_SESSION['administrador'] == "si"){
 
// Variables temporales
$nombre = $apellidos = $email = $administrador = $telefono = $fecha_alta = $foto ="";
$nombreErr = $apellidosErr = $emailErr = $administradorErr = $telefonoErr = $fecha_altaErr = $fotoErr ="";
$fotoanterior="";

if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];

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
    // Procesamos fecha
    $fecha_alta = date("d-m-Y", strtotime(filtrado($_POST["fecha_alta"])));

    if($_FILES['foto']['size']>0 && count($errores)==0){
        $propiedades = explode("/", $_FILES['foto']['type']);
        $extension = $propiedades[1];
        $mod = true;
        // Si no coicide la extensión
        if($extension != "jpg" && $extension != "jpeg"){
            $mod = false;
            $fotoErr= "Formato debe ser jpg/jpeg";
        }

        // Si todo es correcto, mod = true
        if($mod){
            // salvamos la imagen
            $foto = md5($_FILES['foto']['tmp_name'] . $_FILES['foto']['name'].time()) . "." . $extension;
            $controlador = ControladorImagen::getControlador();
            if(!$controlador->salvarImagen($foto)){
                $fotoErr= "Error al procesar la imagen y subirla al servidor";
            }

            // Borramos la antigua
            $fotoAnterior = trim($_POST["fotoAnterior"]);
            if($fotoAnterior!=$foto){
                if(!$controlador->eliminarImagen($fotoAnterior)){
                    $fotoErr= "Error al borrar la antigua imagen en el servidor";
                }
            }
        }else{
        // Si no la hemos modificado
            $foto=trim($_POST["fotoAnterior"]);
        }

    }else{
        $foto=trim($_POST["fotoAnterior"]);
    }
    if(empty($nombreErr) && empty($apellidosErr) && empty($emailErr) && empty($administradorErr) && empty($telefonoErr) 
    && empty($fecha_altaErr) && empty($fotoErr)){
        $controlador= ControladorUsuario::getControlador();
        $estado=$controlador->actualizarUsuario($id, $nombre, $apellidos, $email, $administrador, $telefono, $fecha_alta, $foto);
      

  if($estado){
            header("location: listado_usu.php");
            exit();
        }else{
            alerta("No se a podido enviar la solicitud");
            exit();
        }     
    }else{
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
            $administrador = $usuario->getadministrador();
            $telefono = $usuario->gettelefono();
            $fecha_alta = $usuario->getfecha_alta();
            $foto = $usuario->getfoto();
            $fotoAnterior = $foto;
        } else {
            // hay un error
            header("location: error.php");
            exit();
        }
    } else {
        // hay un error
        header("location: error.php");
        exit();
    }
?>
 
<!-- Cabecera de la página web -->
<?php //require_once VIEW_PATH."cabecera.php"; ?>
<!-- Cuerpo de la página web -->
<h2>Modificar Usuario</h2>

<p>Por favor edite la nueva información para actualizar la ficha.</p>
<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td>
                <!-- Nombre-->
                <div <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>>
                    <label>Nombre</label>
                    <input type="text" name="nombre" value="<?php echo $nombre; ?>">
                    <?php echo $nombreErr; ?>
                </div>
            </td>
            <td>
                <!-- Apellidos-->
                <div <?php echo (!empty($apellidosErr)) ? 'error: ' : ''; ?>>
                    <label>Apellidos</label>
                    <input type="text" name="apellidos" value="<?php echo $apellidos; ?>">
                    <?php echo $apellidosErr; ?>
                </div>
            </td>
            <!-- Fotografía -->
            <td>
                <label>Fotografía Actual</label><br>
                <img src='<?php echo "../../imagenes/fotos/" . $usuario->getfoto() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
            </td>
        </tr>
    </table>

    <div <?php echo (!empty($emailErr)) ? 'error: ' : ''; ?>>
        <label>Correo</label>
        <input type="email" required name="email" value="<?php echo $email; ?>">
        <?php echo $emailErr; ?>
    </div>

    <div class="form-group <?php echo (!empty($administradorErr)) ? 'error: ' : ''; ?>">
        <label>Administrador</label>
        <input type="radio" name="administrador" value="si" <?php echo (strstr($administrador, 'si')) ? 'checked' : ''; ?>>Si</input>
        <input type="radio" name="administrador" value="no" <?php echo (strstr($administrador, 'no')) ? 'checked' : ''; ?>>No</input><br>
        <span class="help-block"><?php echo $administradorErr;?></span>
    </div>
    <!-- Telefono -->
    <div <?php echo (!empty($telefonoErr)) ? 'error: ' : ''; ?>>
        <label>Telefono</label>
        <input type="tel" name="telefono" value="<?php echo $telefono; ?>">
        <?php echo $telefonoErr; ?>
    </div>
    <!-- Fecha de Alta -->
    <div <?php echo (!empty($fecha_altaErr)) ? 'error: ' : ''; ?>>
        <label>Fecha de Inscripción</label>
        <input type="date" required name="fecha_alta" value="<?php echo date('Y-m-d', strtotime($fecha_alta)) ?>">
        <?php echo $fecha_altaErr; ?>
    </div>
    <!-- Foto-->
    <div class="form-group <?php echo (!empty($fotoErr)) ? 'error: ' : ''; ?>">
        <label>Fotografía</label>
        <!-- Solo acepto imagenes jpg -->
        <input type="file" name="foto" class="form-control-file" id="foto" accept="image/jpeg">
        <span class="help-block"><?php echo $fotoErr; ?></span>
    </div>
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="fotoAnterior" value="<?php echo $fotoAnterior; ?>" />
        <button type="submit" value="aceptar"> Modificar</button>
        <a href="listado_usu.php"> Volver</a>
</form>
<br><br><br>
<?php
}else{
    header("location:/musihub/error403.php");
}
}else{
    header("location:/musihub/error403.php");
}
?>
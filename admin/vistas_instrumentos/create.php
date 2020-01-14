<?php
/*//error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
session_start();
if (!isset($_SESSION['USUARIO']['email'])) {
    //echo $_SESSION['USUARIO']['email'];
    //exit();
    header("location: login.php");
    exit();
}*/

require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once CONTROLLER_PATH . "ControladorInstrumento.php";
require_once CONTROLLER_PATH . "ControladorImagen.php";
require_once UTILITY_PATH . "funciones.php";

// Variables
$nombre = $referencia = $distribuidor = $tipo =  $precio = $descuento =  $stockinicial =  $imagen = "";
$nombreVal = $referenciaVal = $distribuidorVal = $tipoVal =  $precioVal = $descuentoVal =  $stockinicialVal =  $imagenVal = "";
$nombreErr = $referenciaErr = $distribuidorErr = $tipoErr =  $precioErr = $descuentoErr =  $stockinicialErr =  $imagenErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["aceptar"]) {
    // Procesamos el nombre
    $nombreVal = filtrado(($_POST["nombre"]));
    if (empty($nombreVal)) {
        $nombreErr = "Por favor introduzca un nombre válido con solo carácteres alfabéticos.";
    } elseif (!preg_match("/([^\s][A-zÀ-ž\s]+$)/", $nombreVal)) {
        $nombreErr = "Por favor introduzca un nombre válido con solo carácteres alfabéticos.";
    } else {
        $nombre = $nombreVal;
    }
    // NO SE REPITA el nombre (si se quiere otro campo modificar el ControladorInstrumento en la funcion buscarInstrumento)
    $controlador = ControladorInstrumento::getControlador();
    $instrumento = $controlador->buscarInstrumentoNom($nombre);
    if (isset($instrumento)) {
        $nombreErr = "Ya existe un instrumento con este nombre:" . $nombreVal . " en la Base de Datos";
    } else {
        $nombre = $nombreVal;
    }

    // Procesamos referencia
    if (isset($_POST["referencia"])) {
        $referencia = filtrado($_POST["referencia"]);
    } elseif (!preg_match("/([1-9])/", $referenciaVal)) {
        $referenciaErr = "Introduzca una referencia valida en numeros";
    } else {
        $referencia = $referenciaVal;
    }

    // Procesamos distribuidor
    if (isset($_POST["distribuidor"])) {
        $distribuidor = filtrado($_POST["distribuidor"]);
    } else {
        $distribuidorErr = "Debe elegir al menos una distribuidor";
    }

    // Procesamos tipo
    if (isset($_POST["tipo"])) {
        $tipo = filtrado($_POST["tipo"]);
    } else {
        $tipoErr = "Tipo incorrecto";
    }

    // Procesamos precio
    if (isset($_POST["precio"])) {
        $precio = filtrado($_POST["precio"]);
    } else {
        $precioErr = "Precio incorrecto";
    }

    // Procesamos descuento
    if (isset($_POST["descuento"])) {
        $descuento = filtrado($_POST["descuento"]);
    } else {
        $descuentoErr = "descuento incorrecto";
    }

    // Procesamos stockinicial
    if (isset($_POST["stockinicial"])) {
        $stockinicial = filtrado($_POST["stockinicial"]);
    } elseif (!preg_match("/([0-9])/", $stockinicialVal)) {
        $stockinicialErr = "Introduzca un stockinicial valido desde el 0";
    } else {
        $stockinicial = $stockinicialVal;
    }

    // Procesamos la foto
    $propiedades = explode("/", $_FILES['imagen']['type']);
    $extension = $propiedades[1];
    $tam_max = 5000000000; 
    $tam = $_FILES['imagen']['size'];
    $mod = true; // para modificar

    // Si no coicide la extensión
    if ($extension != "jpg" && $extension != "jpeg") {
        $mod = false;
        $imagenErr = "Formato debe ser jpg/jpeg";
    }
    // si no tiene el tamaño
    if ($tam > $tam_max) {
        $mod = false;
        $imagenErr = "Tamaño superior al limite de: " . ($tam_max / 1000) . " KBytes";
    }

    if ($mod) {
        //guardar imagen
        $imagen = md5($_FILES['imagen']['tmp_name'] . $_FILES['imagen']['name'] . time()) . "." . $extension;
        $controlador = ControladorImagen::getControlador();
        if (!$controlador->salvarImagenPro($imagen)) {
            $imagenErr = "Error al procesar la imagen y subirla al servidor";
        }
    }
    /*
    //COMPROBAR SOLO ESTOS FILTROS PARA VER SI PASAN LOS DATOS

    echo $nombreVal = filtrado(($_POST["nombre"])).  "<br>";
    echo $raza = filtrado(implode(", ", $_POST["raza"])) .  "<br>";
    echo $ki = filtrado($_POST["ki"]) .  "<br>";
    echo $transformacion = filtrado($_POST["transformacion"]) .  "<br>";
    echo $ataque = filtrado($_POST["ataque"]).  "<br>"; 
    echo $planeta = filtrado($_POST["planeta"]) .  "<br>";
    echo $password = filtrado($_POST["password"]) .  "<br>";
    echo $fecha = filtrado($_POST["fecha"]) .  "<br>";
    echo $imagen = filtrado(($_POST["imagen"]));
*/
    if (
        empty($nombreErr) && empty($referenciaErr) && empty($distribuidorErr) && empty($tipoErr) &&
        empty($precioErr) && empty($descuentoErr) && empty($stockinicialErr) && empty($imagenErr)
    ) {
        // creamos el controlador de instrumentos
        $controlador = ControladorInstrumento::getControlador();
        $estado = $controlador->almacenarInstrumento($nombre, $referencia, $distribuidor, $tipo, $precio, $descuento, $stockinicial, $imagen);
        if ($estado) {
            header("location: ../../index.php");
            exit();
        } else {
            header("location: error.php");
            exit();
        }
    } else {
        alerta("Hay errores al procesar el formulario revise los errores");
    }
} 

?>

<?//php require_once VIEW_PATH . "cabecera.php"; ?>

<h2>Insertar Instrumento</h2>

<p>Por favor rellene este formulario para añadir un nuevo instrumento a la base de datos de la tienda MusiHub.</p>
<!-- Formulario-->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <!-- Nombre-->
    <div <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>>
        <label>Nombre</label>
        <input type="text" required name="nombre" pattern="([^\s][A-zÀ-ž\s]+)" title="El nombre no puede contener números" value="<?php echo $nombre; ?>">
       <?php echo $nombreErr; ?>
    </div>
    <!-- referencia -->
    <div <?php echo (!empty($referenciaErr)) ? 'error: ' : ''; ?>>
        <label>Referencia</label>
        <input type="text" required name="referencia" pattern="([1-9])" min="0" title="Referencia valida solo con numeros" value="<?php echo $referencia; ?>">
       <?php echo $referenciaErr; ?>
    </div>
    <!-- distribuidor -->
    <div <?php echo (!empty($distribuidorErr)) ? 'error: ' : ''; ?>>
        <label>Compañia / Distribuidor</label>
        <input type="text" required name="distribuidor" pattern="([^\s][A-zÀ-ž\s]+)" title="Inserte el nombre de la compañia o distribuidor" value="<?php echo $distribuidor; ?>">
        <?php echo $distribuidorErr; ?>
    </div>
    <!-- tipo-->
    <div <?php echo (!empty($tipoErr)) ? 'error: ' : ''; ?>>
        <label>Tipo de instrumento</label>
        <input type="radio" name="tipo" value="percusion" <?php echo (strstr($tipo, 'percusion')) ? 'checked' : ''; ?>>percusion</input>
        <input type="radio" name="tipo" value="viento" <?php echo (strstr($tipo, 'viento')) ? 'checked' : ''; ?>>viento</input>
        <input type="radio" name="tipo" value="cuerda" <?php echo (strstr($tipo, 'cuerda')) ? 'checked' : ''; ?>>cuerda</input>
        <input type="radio" name="tipo" value="vientometal" <?php echo (strstr($tipo, 'vientometal')) ? 'checked' : ''; ?>>vientometal</input>
        <?php echo $tipoErr; ?>
    </div>
    <!-- Precio -->
    <div <?php echo (!empty($precioErr)) ? 'error: ' : ''; ?>>
        <label>Precio</label>
        <input type="text" required name="precio" value="<?php echo $precio; ?>">
       <?php echo $precioErr; ?>
    </div>
    <!-- descuento-->
    <div <?php echo (!empty($descuentoErr)) ? 'error: ' : ''; ?>>
        <label>Descuento</label>
        <input type="text" name="descuento" minlength="1">
        <?php echo $descuentoErr; ?>
    </div>
    <!-- stockinicial -->
    <div <?php echo (!empty($stockinicialErr)) ? 'error: ' : ''; ?>>
        <label>Stock Inicial</label>
        <input type="text" required name="stockinicial" min="1" pattern="([1-9])" title="Stock valido solo con numeros" value="<?php echo $stockinicial; ?>">
       <?php echo $stockinicialErr; ?>
    </div>
    <!-- Foto-->
    <div <?php echo (!empty($imagenErr)) ? 'error: ' : ''; ?>>
        <label>Fotografía</label>
        <input type="file" required name="imagen" id="imagen" accept="image/jpeg">
        <?php echo $imagenErr; ?>
    </div>
    <!-- Botones -->
    <button type="submit" name="aceptar" value="aceptar" > Aceptar</button>
    <button type="reset" value="reset" > Limpiar</button>
    <a href="../../index.php" > Volver</a>
</form>
<br><br><br>

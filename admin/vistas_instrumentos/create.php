<?php
session_start();
/*//error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
session_start();
if (!isset($_SESSION['USUARIO']['email'])) {
    //echo $_SESSION['USUARIO']['email'];
    //exit();
    header("location: login.php");
    exit();
}*/

//directorios de trabajo
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once CONTROLLER_PATH . "ControladorInstrumento.php";
require_once CONTROLLER_PATH . "ControladorImagen.php";
require_once UTILITY_PATH . "funciones.php";

//Seguro de inicio de sesion con usuario administrador
if (isset($_SESSION['USUARIO']['email'])) {
    if ($_SESSION['administrador'] == "si") {

// ------------------------------------------------------------------------------- 

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
            } elseif (!preg_match("/([0-9]{1,4})/", $referenciaVal)) {
                $referenciaErr = "Introduzca una referencia valida en numeros";
            } else {
                $referencia = $referenciaVal;
            }

            // NO SE REPITA la referencia
            $controlador = ControladorInstrumento::getControlador();
            $instrumento = $controlador->buscarRef($referencia);
            if (isset($instrumento)) {
                $referenciaErr = "Ya existe un instrumento con esta refe:" . $referencia . " en la Base de Datos";
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
            } elseif (!preg_match("/([0-9,]{1,6})/", $precioVal)) {
                $precioErr = "Introduzca un precio valido";
            } else {
                $precio = $precioVal;
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
            } elseif (!preg_match("/([0-9]{1,4})/", $stockinicialVal)) {
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

        <? //php require_once VIEW_PATH . "cabecera.php"; 
        ?>
        <link rel="icon" type="image/png" href="logo.png">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <div class="wrapper">
            <title>Insertar Instrumento</title>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <h2>Insertar Instrumento</h2>
                                <br>
                            <p>Por favor rellene este formulario para añadir un nuevo instrumento a la base de datos de la tienda MusiHub.</p>
                            <br>
                            <!-- Formulario-->
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                <!-- Nombre-->
                                <div class="form-group <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>">
                                    <label>Nombre</label>
                                    <input class="form-control" type="text" required name="nombre" pattern="([^\s][A-zÀ-ž\s]+)" title="El nombre no puede contener números" value="<?php echo $nombre; ?>">
                                    <?php echo $nombreErr; ?>
                                </div>
                                <!-- referencia -->
                                <div class="form-group <?php echo (!empty($referenciaErr)) ? 'error: ' : ''; ?>">
                                    <label>Referencia</label>
                                    <input class="form-control" type="text" required name="referencia" pattern="([0-9]{1,4})" min="1" max="4" title="Referencia valida solo con numeros" value="<?php echo $referencia; ?>">
                                    <?php echo $referenciaErr; ?>
                                </div>
                                <!-- distribuidor -->
                                <div class="form-group <?php echo (!empty($distribuidorErr)) ? 'error: ' : ''; ?>">
                                    <label>Compañia / Distribuidor</label>
                                    <input class="form-control" type="text" required name="distribuidor" pattern="([^\s][A-zÀ-ž\s]+)" title="Inserte el nombre de la compañia o distribuidor" value="<?php echo $distribuidor; ?>">
                                    <?php echo $distribuidorErr; ?>
                                </div>
                                <!-- tipo-->
                                <div class="form-group <?php echo (!empty($tipoErr)) ? 'error: ' : ''; ?>">
                                    <p><label>Tipo de instrumento</label></p>
                                    <input type="radio" name="tipo" value="percusion" <?php echo (strstr($tipo, 'percusion')) ? 'checked' : ''; ?>>percusion</input>
                                    <input type="radio" name="tipo" value="viento" <?php echo (strstr($tipo, 'viento')) ? 'checked' : ''; ?>>viento</input>
                                    <input type="radio" name="tipo" value="cuerda" <?php echo (strstr($tipo, 'cuerda')) ? 'checked' : ''; ?>>cuerda</input>
                                    <input type="radio" name="tipo" value="vientometal" <?php echo (strstr($tipo, 'vientometal')) ? 'checked' : ''; ?>>vientometal</input>
                                    <?php echo $tipoErr; ?>
                                </div>
                                <!-- Precio -->
                                <div class="form-group <?php echo (!empty($precioErr)) ? 'error: ' : ''; ?>">
                                    <label>Precio</label>
                                    <input class="form-control" type="text" required name="precio" pattern="([0-9,]{1,6})" value="<?php echo $precio; ?>">
                                    <?php echo $precioErr; ?>
                                </div>
                                <!-- descuento-->
                                <div class="form-group <?php echo (!empty($descuentoErr)) ? 'error: ' : ''; ?>">
                                    <label>Descuento</label>
                                    <input class="form-control" type="text" name="descuento" minlength="1">
                                    <?php echo $descuentoErr; ?>
                                </div>
                                <!-- stockinicial -->
                                <div class="form-group <?php echo (!empty($stockinicialErr)) ? 'error: ' : ''; ?>">
                                    <label>Stock Inicial</label>
                                    <input class="form-control" type="text" required name="stockinicial" min="1" max="4" pattern="[0-9]{1,4}" title="Stock valido solo con numeros" value="<?php echo $stockinicial; ?>">
                                    <?php echo $stockinicialErr; ?>
                                </div>
                                <!-- Foto-->
                                <div class="form-group <?php echo (!empty($imagenErr)) ? 'error: ' : ''; ?>">
                                    <label>Fotografía</label>
                                    <input class="form-control-file" type="file" required name="imagen" id="imagen" accept="image/jpeg">
                                    <?php echo $imagenErr; ?>
                                </div>
                                <!-- Botones -->
                                <div class="form-group">
                                    <button type="submit" name="aceptar" value="aceptar" class="btn btn-success">Aceptar</button>
                                    <button type="reset" class="btn btn-warning">Limpiar</button>
                                    <a href="./listado.php" class="btn btn-primary">Volver</a>
                                </div>
                            </form>
                            <br><br><br>
                    <?php
                    // si el usuario logueado no es admin no podra insertar ningun instrumento en la base de datos
                    // Este seguro obliga a ser ADMIN como usuario logueado
                } else {
                    header("location:/musihub/error403.php");
                }
            } else {
                header("location:/musihub/error403.php");
            }
                    ?>
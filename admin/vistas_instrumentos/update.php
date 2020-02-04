<?php
// Incluimos el controlador a los objetos a usar
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once CONTROLLER_PATH . "ControladorInstrumento.php";
require_once CONTROLLER_PATH . "ControladorImagen.php";
require_once UTILITY_PATH . "funciones.php";
session_start();
if (isset($_SESSION['USUARIO']['email'])) {
    if ($_SESSION['administrador'] == "si") {
        // Variables temporales
        $nombre = $referencia = $distribuidor = $tipo =  $precio = $descuento =  $stockinicial =  $imagen = "";
        $nombreErr = $referenciaErr = $distribuidorErr = $tipoErr =  $precioErr = $descuentoErr =  $stockinicialErr =  $imagenErr = "";
        $imagenAnterior = "";
        $errores = [];

        // Procesamos la información obtenida por el get
        if (isset($_POST["id"]) && !empty($_POST["id"])) {
            // Get hidden input value
            $id = $_POST["id"];

            // Procesamos el nombre
            $nombreVal = filtrado(($_POST["nombre"]));
            if (empty($nombreVal)) {
                $nombreErr = "Por favor introduzca un nombre válido con solo carácteres alfabéticos.";
            } elseif (!preg_match("/([^\s][A-zÀ-ž\s]+$)/", $nombreVal)) {
                $nombreErr = "Por favor introduzca un nombre válido con solo carácteres alfabéticos.";
            } else {
                $nombre = $nombreVal;
            }

            // Procesamos referencia
            if (isset($_POST["referencia"])) {
                $referencia = filtrado($_POST["referencia"]);
            } elseif (!preg_match("/[0123456789]{1,8}/", $referenciaVal)) {
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
            } elseif (!preg_match("/[0123456789]{1,8}/", $stockinicialVal)) {
                $stockinicialErr = "Introduzca un stockinicial valido desde el 0";
            } else {
                $stockinicial = $stockinicialVal;
            }


            // Procesamos la imagen
            // Si nos ha llegado algo mayor que cero
            if ($_FILES['imagen']['size'] > 0 && count($errores) == 0) {
                $propiedades = explode("/", $_FILES['imagen']['type']);
                $extension = $propiedades[1];
                $tam_max = 5000000000;
                $tam = $_FILES['imagen']['size'];
                $mod = true;
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

                // Si todo es correcto, mod = true
                if ($mod) {
                    // salvamos la imagen
                    $imagen = md5($_FILES['imagen']['tmp_name'] . $_FILES['imagen']['name'] . time()) . "." . $extension;
                    $controlador = ControladorImagen::getControlador();
                    if (!$controlador->salvarImagenPro($imagen)) {
                        $imagenErr = "Error al procesar la imagen y subirla al servidor";
                    }

                    // Borramos la antigua
                    $imagenAnterior = trim($_POST["imagenAnterior"]);
                    if ($imagenAnterior != $imagen) {
                        if (!$controlador->eliminarImagen($imagenAnterior)) {
                            $imagenErr = "Error al borrar la antigua imagen en el servidor";
                        }
                    }
                } else {
                    // Si no la hemos modificado
                    $imagen = trim($_POST["imagenAnterior"]);
                }
            } else {
                $imagen = trim($_POST["imagenAnterior"]);
            }

            // Chequeamos los errores antes de insertar en la base de datos
            if (
                empty($nombreErr) && empty($referenciaErr) && empty($distribuidorErr) && empty($tipoErr) &&
                empty($precioErr) && empty($descuentoErr) && empty($stockinicialErr) && empty($imagenErr)
            ) {
                // creamos el controlador de alumnado
                $controlador = ControladorInstrumento::getControlador();
                $estado = $controlador->actualizarInstrumento($id, $nombre, $referencia, $distribuidor, $tipo, $precio, $descuento, $stockinicial, $imagen);
                if ($estado) {
                    $errores = [];
                    // El registro se ha lamacenado corectamente
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



        // Comprobamos que existe el id antes de ir más lejos
        if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
            $id =  decode($_GET["id"]);
            $controlador = ControladorInstrumento::getControlador();
            $instrumento = $controlador->buscarInstrumentoid($id);
            if (!is_null($instrumento)) {
                $nombre = $instrumento->getnombre();
                $referencia = $instrumento->getreferencia();
                $distribuidor = $instrumento->getdistribuidor();
                $tipo = $instrumento->gettipo();
                $precio = $instrumento->getprecio();
                $descuento = $instrumento->getdescuento();
                $stockinicial = $instrumento->getstockinicial();
                $imagen = $instrumento->getimagen();
                $imagenAnterior = $imagen;
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
        <?php //require_once VIEW_PATH."cabecera.php"; 
        ?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Actualizar Instrumento</title>
            <link rel="icon" type="image/png" href="logo.png">
            <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
        <!-- Cuerpo de la página web -->

        <body class="bg-dark">
            <header class="bg-dark" style="height: 60px; padding: 5px;">
                <h3 class="text-light" style="text-align: center;">Modificar instrumento</h3>
            </header>
            <div class="container bg-dark">
                <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6 bg-light boxStyle">
                        <center><p>Por favor edite la nueva información para actualizar la ficha.</p></center>
                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                            <table>
                                <tr>
                                    <td>
                                        <!-- Nombre-->
                                        <div class="form-group">
                                            <div <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>>
                                                <div class="width30 floatL"><label>Nombre</label></div>
                                                <div class="width70 floatR"><input class="width100 form-control" type="text" name="nombre" value="<?php echo $nombre; ?>"></div>
                                                <?php echo $nombreErr; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Fotografía -->
                                    <td style="position:absolute; left:400px;">
                                        <img src='<?php echo "../../imagenes/fotos/" . $instrumento->getimagen() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <!-- referencia -->
                            <div class="form-group">
                                <div <?php echo (!empty($referenciaErr)) ? 'error: ' : ''; ?>>
                                    <div class="width30 floatL"><label>Referencia</label></div>
                                    <div class="width70 floatR"><input class="width100 form-control" type="text" required name="referencia" value="<?php echo $referencia; ?>" pattern="[0123456789]{1,8}" title="Referencia valida solo con numeros"></div>
                                    <?php echo $referenciaErr; ?>
                                </div>
                            </div>
                            <br><br><br>
                            <!-- distribuidor -->
                            <div class="form-group">
                                <div <?php echo (!empty($distribuidorErr)) ? 'error: ' : ''; ?>>
                                    <div class="width30 floatL"><label>Compañia / Distribuidor</label></div>
                                    <div class="width70 floatR"><input class="width100 form-control" type="text" required name="distribuidor" pattern="([^\s][A-zÀ-ž\s]+)" title="Inserte el nombre de la compañia o distribuidor" value="<?php echo $distribuidor; ?>"></div>
                                    <?php echo $distribuidorErr; ?>
                                </div>
                            </div>
                            <br><br><br>
                            
                            <!-- tipo -->
                            <div class="form-group">
                                <div <?php echo (!empty($tipoErr)) ? 'error: ' : ''; ?>>
                                    <div class="width30 floatL"><label>Tipo de instrumento</label></div>
                                    <div class="width70 floatR"><input type="radio" name="tipo" value="percusion" <?php echo (strstr($tipo, 'percusion')) ? 'checked' : ''; ?>> percusion</input></div>
                                    <div class="width70 floatR"><input type="radio" name="tipo" value="viento" <?php echo (strstr($tipo, 'viento')) ? 'checked' : ''; ?>> viento</input></div>
                                    <div class="width70 floatR"><input type="radio" name="tipo" value="cuerda" <?php echo (strstr($tipo, 'cuerda')) ? 'checked' : ''; ?>> cuerda</input></div>
                                    <div class="width70 floatR"><input type="radio" name="tipo" value="vientometal" <?php echo (strstr($tipo, 'vientometal')) ? 'checked' : ''; ?>> vientometal</input></div>
                                    <?php echo $tipoErr; ?>
                                </div>
                            </div><br><br><br><br>
                            <!-- Precio -->
                            <div class="form-group">
                                <div <?php echo (!empty($precioErr)) ? 'error: ' : ''; ?>>
                                    <div class="width30 floatL"><label>Precio</label></div>
                                    <div class="width70 floatR"><input class="width100 form-control" type="text" required name="precio" value="<?php echo $precio; ?>"></div>
                                    <?php echo $precioErr; ?>
                                </div>
                            </div><br><br><br>
                            <!-- descuento-->
                            <div class="form-group">
                                <div <?php echo (!empty($descuentoErr)) ? 'error: ' : ''; ?>>
                                    <div class="width30 floatL"><label>Descuento</label></div>
                                    <div class="width70 floatR"><input class="width100 form-control" type="text" name="descuento" minlength="1" value="<?php echo $descuento; ?>"></div>
                                    <?php echo $descuentoErr; ?>
                                </div>
                            </div><br><br><br>
                            <!-- stockinicial -->
                            <div class="form-group">
                                <div <?php echo (!empty($stockinicialErr)) ? 'error: ' : ''; ?>>
                                    <div class="width30 floatL"><label>Stock Inicial</label></div>
                                    <div class="width70 floatR">
                                        <div class="width70 floatR"><input class="width100 form-control" type="text" required name="stockinicial" min="1" pattern="[0123456789]{1,8}" title="Stock valido solo con numeros" value="<?php echo $stockinicial; ?>"></div>
                                        <?php echo $stockinicialErr; ?>
                                    </div>
                                </div><br><br><br>
                                <!-- Foto-->
                                <div class="form-group">
                                    <div class="form-group <?php echo (!empty($imagenErr)) ? 'error: ' : ''; ?>">
                                        <div class="width30 floatL"><label>Fotografía</label></div>
                                        <!-- Solo acepto imagenes jpg -->
                                        <div class="width70 floatR"><input class="width100 form-control" type="file" name="imagen" class="form-control-file" id="imagen" accept="image/jpeg"></div>
                                        <span class="help-block"><?php echo $imagenErr; ?></span>
                                    </div>
                                </div>
                                <br><br><br>
                                <center>
                                    <p>
                                        <div class="width50"><input class="btn btn-success" type="submit" value="Modificar" style="font-weight: bold"></div>
                                    </p>
                                    <p>
                                        <div class="width50"><input class="btn btn-danger" type="reset" style="font-weight: bold"></div>
                                    </p>
                                    <a href="listado.php"> Volver</a>
                                </center>

                                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                                <input type="hidden" name="imagenAnterior" value="<?php echo $imagenAnterior; ?>" />
                        </form>
                        </div>
                <div class="col-sm-1"></div>
                <div class="col-sm-2"></div>
            </div>
        </div>
    </body>
                        <br><br><br>
                        <!-- Pie de la página web -->
                <?php
            } else {
                header("location:/musihub/error403.php");
            }
        } else {
            header("location:/musihub/error403.php");
        }
                ?>
                <?php //require_once VIEW_PATH . "pie.php"; 
                ?>
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
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once CONTROLLER_PATH . "ControladorInstrumento.php";
require_once CONTROLLER_PATH . "ControladorImagen.php";
require_once UTILITY_PATH . "funciones.php";
if (isset($_SESSION['USUARIO']['email'])) {
    if ($_SESSION['administrador'] == "si") {
        if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
            $id = decode($_GET["id"]);
            $controlador = ControladorInstrumento::getControlador();
            $instrumento = $controlador->buscarInstrumentoid($id);
            if (is_null($instrumento)) {
                header("location: error.php");
                exit();
            }
        }


        if (isset($_POST["id"]) && !empty($_POST["id"])) {
            $controlador = ControladorInstrumento::getControlador();
            $instrumento = $controlador->buscarInstrumentoid($_POST["id"]);
            if ($controlador->borrarInstrumento($_POST["id"])) {

                $controlador = ControladorImagen::getControlador();
                if ($controlador->eliminarImagen($instrumento->getimagen())) {
                    header("location: ../../index.php");
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

        <?php //require_once VIEW_PATH . "cabecera.php"; 
        ?>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                    <h1>
                        <center>Borrar Instrumento</center>
                    </h1>
                    <hr class="colorgraph">

                    <table>
                        <tr>
                            <td>
                                <div>
                                    <label>Nombre</label>
                                    <p><?php echo $instrumento->getnombre(); ?></p>
                                </div>
                            </td>
                            <td style="position:absolute; left:400px;">
                                <img src='<?php echo "../../imagenes/fotos/" . $instrumento->getimagen() ?>' width='150' height='auto'>
                            </td>
                        </tr>
                    </table>
                    <div>
                        <label>Referencia</label>
                        <p><?php echo $instrumento->getreferencia(); ?></p>
                    </div>
                    <div>
                        <label>Distribuidor</label>
                        <p><?php echo $instrumento->getdistribuidor(); ?></p>
                    </div>
                    <div>
                        <label>Tipo</label>
                        <p><?php echo $instrumento->gettipo(); ?></p>
                    </div>
                    <div>
                        <label>Precio</label>
                        <p><?php echo $instrumento->getprecio(); ?></p>
                    </div>
                    <div>
                        <label>Descuento</label>
                        <p><?php echo $instrumento->getdescuento(); ?></p>
                    </div>
                    <div>
                        <label>Stock</label>
                        <p><?php echo $instrumento->getstockinicial(); ?></p>
                    </div>
                    <hr class="colorgraph">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="alert alert-danger fade in">
                            <input type="hidden" name="id" value="<?php echo trim($id); ?>" />
                            <p>¿Está seguro que desea borrar este instrumento?</p><br>
                            <p>
                                <button type="submit" class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span> Borrar</button>
                                <a href="listado.php" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                            </p>
                        </div>
                    </form>
                    <br><br><br>
            <?php
        } else {
            header("location:/musihub/error403.php");
        }
    } else {
        header("location:/musihub/error403.php");
    }
            ?>
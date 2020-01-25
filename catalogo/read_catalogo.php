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
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once CONTROLLER_PATH . "ControladorInstrumento.php";
require_once UTILITY_PATH . "funciones.php";

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = decode($_GET["id"]);
    $controlador = ControladorInstrumento::getControlador();
    $instrumento = $controlador->buscarInstrumentoid($id);
    if (is_null($instrumento)) {
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
            <h1><center>Detalles del Instrumento</center></h1>
            <hr class="colorgraph">
            <table style=>
                <tr>
                    <td>
                        <big><label>Nombre</label></big>
                        <p><?php echo $instrumento->getnombre(); ?></p>
                    </td>
                    <td style="position:absolute; left:400px;">
                        <big><label>Fotografía</label><br></big>
                        <img src='<?php echo "../imagenes/fotos/" . $instrumento->getimagen() ?>' class='rounded' class='img-thumbnail' width='150' height='auto'>
                    </td>
                </tr>
            </table>
            <br>
            <center>
                <label>Referencia</label>
                <p><?php echo $instrumento->getreferencia(); ?></p>
            </center>
            <br>
            <center>
                <label>Distribuidor</label>

                <p><?php echo $instrumento->getdistribuidor(); ?></p>
            </center>
            <br>
            <center>
                <label>tipo</label>
                <p><?php echo $instrumento->gettipo(); ?></p>
            </center>
            <br>
            <center>
                <label>precio</label>
                <p><?php echo $instrumento->getprecio(); ?></p>
            </center>
            <br>
            <center>
                <label>descuento</label>
                <p><?php echo $instrumento->getdescuento(); ?></p>
            </center>
            <br>
            <center>
                <label>stockinicial</label>
                <p><?php echo $instrumento->getstockinicial(); ?></p>
            </center>
            <hr class="colorgraph">

            <p>
            <div class="col-xs-12 col-md-6"><a href="../index.php" class="btn btn-primary btn-block btn-lg"> Aceptar</a>
            </p>
        </div>
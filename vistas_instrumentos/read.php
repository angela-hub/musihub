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

<?php //require_once VIEW_PATH . "cabecera.php"; ?>

<h1>Ficha del Instrumento</h1>
<table>
    <tr>
        <td>
            <label>Nombre</label>
            <p><?php echo $instrumento->getnombre(); ?></p>
        </td>
        <td>
            <label>Fotografía</label><br>
            <img src='<?php echo "../imagenes/fotos/" . $instrumento->getimagen() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
        </td>
    </tr>
</table>

<label>Referencia</label>
<p><?php echo $instrumento->getreferencia(); ?></p>

<label>Distribuidor</label>

<p><?php echo $instrumento->getdistribuidor(); ?></p>

<label>tipo</label>
<p><?php echo $instrumento->gettipo(); ?></p>

<label>precio</label>
<p><?php echo $instrumento->getprecio(); ?></p>

<label>descuento</label>
<p><?php echo $instrumento->getdescuento(); ?></p>

<label>stockinicial</label>
<p><?php echo $instrumento->getstockinicial(); ?></p>

<p><a href="../index.php"> Aceptar</a></p>
<br><br><br>
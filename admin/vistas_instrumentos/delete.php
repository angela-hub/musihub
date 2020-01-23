<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once CONTROLLER_PATH . "ControladorInstrumento.php";
require_once CONTROLLER_PATH . "ControladorImagen.php";
require_once UTILITY_PATH . "funciones.php";
if(isset($_SESSION['USUARIO']['email'])){
if($_SESSION['administrador'] == "si"){
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

<?php //require_once VIEW_PATH . "cabecera.php"; ?>

<h1>Borrar Instrumento</h1>

<table>
    <tr>
        <td>
            <div>
                <label>Nombre</label>
                <p><?php echo $instrumento->getnombre(); ?></p>
            </div>
        </td>
        <td>
            <label>Fotografía</label><br>
            <img src='<?php echo "../../imagenes/fotos/" . $instrumento->getimagen() ?>' width='48' height='auto'>
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

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div>
        <input type="hidden" name="id" value="<?php echo trim($id); ?>" />
        <p>¿Está seguro que desea borrar este instrumento?</p><br>
        <p>
            <button type="submit"> Borrar</button>
            <a href="listado.php"> Volver</a>
        </p>
    </div>
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
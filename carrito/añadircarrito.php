<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once VIEW_PATH . "../cabecera.php";
require_once CONTROLLER_PATH . "ControladorCarrito.php";

// Compramos si existe el campo ID
if (isset($_GET["id"]) && !empty(trim($_GET["id"])) && isset($_GET["page"]) && !empty(trim($_GET["page"]))) {
    $id = decode($_GET["id"]);
    $page = decode($_GET["page"]);
    // Cargamos el controlador
    $controlador = ControladorInstrumento::getControlador();
    $producto= $controlador->buscarinstrumentoid($id);
    // Lo insertamos y vamos a la página anterior
    $carrito = ControladorCarrito::getControlador();
    if ($carrito->insertarLineaCarrito($producto,1)) {
        // si es correcto recarga la página y actualizamos la cookie
        // Volvemos atras
        header("location:".$page);
        exit();
    }

}

//si no existe el usuario lo enviamos a error para que no haga nada
if (is_null($producto)) {
    // hay un error
    alerta("Operación no permitida", "error.php");
    exit();
}
<?php
session_start(); // obliga a iniciar sesion

// directorios requeridos de trabajo
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once CONTROLLER_PATH . "ControladorDescarga.php";

// si el usuario es administrador podra hacer usos de las utilidades de descarga sino no tendra acceso el usuario normal
if(isset($_SESSION['USUARIO']['email'])){
    $opcion = $_GET["opcion"];
    if($_SESSION['administrador'] == "si"){
    // opciones de descarga en TXT, JSON, XML, PDF
$fichero = ControladorDescarga::getControlador();
switch ($opcion) {
    case 'TXT':
        $fichero->descargarTXT();
        break;
    case 'JSON':
        $fichero->descargarJSON();
        break;
    case 'XML':
        $fichero->descargarXML();
        break;
    case 'PDF':
        $fichero->descargarPDF();
        break;
    case 'TXTUsu':
        $fichero->descargarTXTUsu();
        break;
    case 'JSONUsu':
        $fichero->descargarJSONUsu();
        break;
    case 'XMLUsu':
        $fichero->descargarXMLUsu();
        break;
    case 'PDFUsu':
        $fichero->descargarPDFUsu();
        break;
    case 'FACTURA';
    $id = decode($_GET["id"]);
        $fichero ->descargarfactura($id);
        break;
}
// En caso de que este logeado pero no sea administrador solo le dejará ver su factura.
}else{
    $fichero = ControladorDescarga::getControlador();
    switch ($opcion) {
        case 'FACTURA';
        $id = decode($_GET["id"]);
        $fichero ->descargarfactura($id);
        break;
        //Si no es esa opcion le dara como error de permisos
        default;
            header("location:/musihub/error403.php");
        break;
        }
}
//Si no esta logeado tampoco le llevara a una página de error
}else{
    header("location:/musihub/error403.php");
}
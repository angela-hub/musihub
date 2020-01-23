<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once CONTROLLER_PATH . "ControladorDescarga.php";
if(isset($_SESSION['USUARIO']['email'])){
    if($_SESSION['administrador'] == "si"){
$opcion = $_GET["opcion"];
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
}
}else{
    header("location:/musihub/error403.php");
}
}else{
    header("location:/musihub/error403.php");
}
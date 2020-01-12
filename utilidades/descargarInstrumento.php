<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once CONTROLLER_PATH . "ControladorDescargaInstrumento.php";
$opcion = $_GET["opcion"];
$fichero = ControladorDescargaInstrumento::getControlador();
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
}

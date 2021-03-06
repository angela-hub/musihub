<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/musihub/dirs.php";
    require_once CONTROLLER_PATH."ControladorUsuario.php";
    require_once CONTROLLER_PATH."ControladorInstrumento.php";
    require_once UTILITY_PATH."funciones.php";

class ControladorImagen {
    static private $instancia = null;
    private function __construct() {
        //echo "Conector creado";
    }
    /**
     * Patrón Singleton. Ontiene una instancia del Controlador de Descargas
     * @return instancia de conexion
     */
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorImagen();
        }
        return self::$instancia;
    }
//--------------------------------------------------------------------------------------------
// Creamos las funciones para guardar la imagen, tenemos dos funciones una la utilizaremos para los usuario sy otra para los productos
    function salvarImagen($foto) {
        if (move_uploaded_file($_FILES['foto']['tmp_name'], IMAGE_PATH ."fotos/" . $foto)) {
            return true;
        }
        return false;
    }

    function salvarImagenPro($imagen) {
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], IMAGE_PATH ."fotos/" . $imagen)) {
            return true;
        }
        return false;
    }
//--------------------------------------------------------------------------------------------
// Creamos las funciones para eliminar una imagen de igual forma para ambos modelos
    function eliminarImagen($imagen) {
        $fichero = IMAGE_PATH ."fotos/" . $imagen;
        if (file_exists($fichero)) {
            unlink($fichero);
            return true;
        }
        return false;;
    }
    function eliminarFoto($foto) {
        $fichero = IMAGE_PATH ."fotos/" . $foto;
        if (file_exists($fichero)) {
            unlink($fichero);
            return true;
        }
        return false;;
    }
//--------------------------------------------------------------------------------------------
// Creamos la funcion para actualizar una foto de un instrumento o usuario
    function actualizarFoto(){
        $fotoAnterior = trim($_POST["fotoAnterior"]);
        $extension = explode("/", $_FILES['foto']['type']);
        $nombreFoto = md5($_FILES['foto']['tmp_name'] . $_FILES['foto']['name']) . "." . $extension[1];
        if (!move_uploaded_file($_FILES['foto']['tmp_name'], ROOT_PATH . "/fotos/$nombreFoto")) {
            $nombreFoto = $fotoAnterior;
        }
        return $nombreFoto;
    }

}

?>
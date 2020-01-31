<?php


require_once MODEL_PATH . "lineaventa.php";
require_once MODEL_PATH . "venta.php";
require_once MODEL_PATH . "instrumento.php";
require_once MODEL_PATH . "usuario.php";
require_once CONTROLLER_PATH . "ControladorBD.php";

class ControladorCarrito {

    static private $instancia = null;
    private function __construct() {

    }

    /**
     * Patrón Singleton. Ontiene una instancia del Manejador de la BD
     * @return instancia de conexion
     */
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorCarrito();
        }
        return self::$instancia;
    }


    /**
     * Inserta una línea de venta, instrumento, y unidades
     * @param Instrumento $instrumento
     * @param $uds
     * @return bool
     */
    public function insertarLineaCarrito(Instrumento $instrumento, $uds) {
        $conexion = ControladorInstrumento::getControlador();
        $articulo = $conexion->buscarinstrumentoid($instrumento->getId());
        $udsStock = $articulo->getstockinicial();

        $carrito = new ControladorCarrito();
        $udsCarrito = $carrito->unidadesArticulo($instrumento->getId());


        if (($udsStock - ($uds+$udsCarrito)) >= 0) {
            $_SESSION['uds'] += $uds;

            if (array_key_exists($instrumento->getId(), $_SESSION['carrito'])&& ($_SESSION['carrito'][$instrumento->getId()][0]!=null)) {
                echo "<br><br><br>Existe";
                $uds = $_SESSION['carrito'][$instrumento->getId()][1] + $uds;
            }
            $_SESSION['carrito'][$instrumento->getId()] = [$instrumento, $uds];
            return true;
        } else {
            $id = encode($instrumento->getId());
            alerta("No hay en stock suficiente tras añadir este instrumento a tu carrito", "instrumento.php?id=$id"); //devolvemos el foco al mismo sitio
            return false;
        }
    }

    /**
     * Comprueba las unidades de un instrumento en el carrito
     * @param $id
     * @return int
     */
    public function unidadesArticulo($id){

        $uds=0;
        if (array_key_exists($id, $_SESSION['carrito'])) {
            $uds = $_SESSION['carrito'][$id][1];
        }
        return $uds;
    }

    /**
     * Actualiza las líneas de Carrito
     * @param $id
     * @param $uds
     * @return bool
     */
    public function actualizarLineaCarrito($id, $uds) {
        $conexion = ControladorInstrumento::getControlador();
        $articulo = $conexion->buscarinstrumentoId($id);
        $udsStock = $articulo->getstockinicial();

        if (($udsStock - $uds) >= 0) {
            $udsAnteriores = $_SESSION['carrito'][$id][1];
            $udsActualizar = $uds - $udsAnteriores;
            $_SESSION['carrito'][$id][1] = $uds;
            $_SESSION['uds'] += $udsActualizar;
            return true;
        } else {

            alerta("No hay en stock", "carritoMostrar.php");
            return false;
        }
    }

    /**
     * Elimina la líneas de carrito
     * @param $id
     * @param $uds
     */
    public function borrarLineaCarrito($id, $uds) {
        unset($_SESSION['carrito'][$id]);
        $_SESSION['uds'] -= $uds;
    }

    /**
     * Devuelve el número de líenas de carrito
     * @return int
     */
    public function unidadesEnCarrito(){
        $total=0;
        if(isset($_SESSION['carrito'])){
            foreach ($_SESSION['carrito'] as $key => $value) {
                if($value[0]!=null) {
                    $total += $value[1];
                }
            }
        }
        if($total==0){
            unset($_SESSION['carrito']);
            $_SESSION['uds'] = 0;
        }
        return $total;
    }

    public function vaciarCarrito() {
        unset($_SESSION['carrito']);
        $_SESSION['uds'] = 0;
    }

}
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
    //--------------------------------------------------------------------------------------------
    // Creamos la funcion para insertarLineas de carrito
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
            header("location:/musihub/sinstock.php"); //devolvemos el foco al mismo sitio
            return false;
        }
    }

    /**
     * Comprueba las unidades de un instrumento en el carrito
     * @param $id
     * @return int
     */
    //--------------------------------------------------------------------------------------------
    // Creamos la funcion para ver las unidades que hay de un articulo
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
    //--------------------------------------------------------------------------------------------
    // Creamos la funcion para actualizar las lineas del carrito desde los formularios creados en el carrito
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

            alerta("No hay en stock");
            header("location:/musihub/sinstock.php"); //devolvemos el foco al mismo sitio
            return false;
        }
    }
//--------------------------------------------------------------------------------------------
    /**
     * Elimina la líneas de carrito
     * @param $id
     * @param $uds
     */
    //Creamos la funcion de borrarlínea de carrito para ir borrando articulos de uno en uno del carrito
    public function borrarLineaCarrito($id, $uds) {
        unset($_SESSION['carrito'][$id]);
        $_SESSION['uds'] -= $uds;
    }

    /**
     * Devuelve el número de líenas de carrito
     * @return int
     */
    //--------------------------------------------------------------------------------------------
    //Creamos la funcion para ver las unidades totales que hay en el carrito
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
//--------------------------------------------------------------------------------------------
    //Creamos la funcion precio en carrito para saber cuanto llevamos gastado, lo cual nos aparcera al lado de los articulos en el carrito de la cabecera
    public function precioencarrito(){
        $total=0;
        if(isset($_SESSION['carrito'])){
            foreach ($_SESSION['carrito'] as $key => $value) {
                $id = $key;
                if ($value[0] != null) {
                    $instrumento = $value[0];
                    $cantidad = $value[1];
                    $total += $instrumento->getprecio() * $cantidad;
                }
            }
        }
        if($total==0){
            unset($_SESSION['carrito']);
            $_SESSION['total'] = 0;
        }
        return $total;
    }
//--------------------------------------------------------------------------------------------
    //Creamos la funcion vaciar carrito con la cual vaciaremos el carrito entero
    public function vaciarCarrito() {
        unset($_SESSION['carrito']);
        $_SESSION['uds'] = 0;
    }

}
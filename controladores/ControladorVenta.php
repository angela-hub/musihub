<?php

require_once MODEL_PATH . "venta.php";
require_once MODEL_PATH . "lineaventa.php";
require_once CONTROLLER_PATH . "ControladorBD.php";
require_once CONTROLLER_PATH . "ControladorInstrumento.php";

class ControladorVenta {

    static private $instancia = null;

    private function __construct() {

    }

    /**
     * Patrón Singleton. Ontiene una instancia del Manejador de la BD
     * @return instancia de conexion
     */
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorVenta();
        }
        return self::$instancia;
    }

    /**
     * Buscar la venta por un id
     * @param $id
     * @return Venta|null
     */

/*--------------------------------------------------------------------------------------------------------------------- */
/* Buscar una venta por ID */
    public function buscarVentaID($id) {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();

        $consulta = "select * from ventas where idVenta = :idVenta";
        $parametros = array(':idVenta' => $id);

        $res = $bd->consultarBD($consulta, $parametros);
        $filas = $res->fetchAll(PDO::FETCH_OBJ);

        if (count($filas) > 0) {
            $venta = new Venta($filas[0]->idVenta, $filas[0]->fecha, $filas[0]->total,
                $filas[0]->subtotal, $filas[0]->iva, $filas[0]->nombre, $filas[0]->email, $filas[0]->direccion,
                $filas[0]->nombreTarjeta, $filas[0]->numTarjeta);
            $bd->cerrarBD();
            return $venta;
        } else {
            return null;
        }

    }
/*---------------------------------------------------------------------------------------------------------------------- */
/* Buscar los productos a vender de la linea por el ID */
    public function buscarLineasID($id) {
        $lista = [];

        $bd = ControladorBD::getControlador();
        $bd->abrirBD();

        $consulta = "select * from lineasventas where idVenta = :idVenta";
        $parametros = array(':idVenta' => $id);

        $res = $bd->consultarBD($consulta, $parametros);
        $filas = $res->fetchAll(PDO::FETCH_OBJ);

        if (count($filas) > 0) {
            foreach ($filas as $venta) {
                $venta = new lineaventa($venta->idVenta, $venta->idProducto, $venta->distribuidor,
                    $venta->tipo, $venta->precio, $venta->cantidad);
                $bd->cerrarBD();
                $lista[] = $venta;
            }
            return $lista;
        } else {
            return null;
        }

    }
/*-------------------------------------------------------------------------------------------------------------------------*/
    
    public function insertarVenta($venta) {
        $conexion = ControladorBD::getControlador();
        $conexion->abrirBD();
        $consulta = "insert into ventas (idVenta, total, subtotal, iva, nombre, email, direccion, 
                    nombreTarjeta, numTarjeta) 
            values (:idVenta, :total, :subtotal, :iva, :nombre, :email, :direccion, :nombreTarjeta, :numTarjeta)";

        $parametros = array(':idVenta' => $venta->getId(), ':total' => $venta->getTotal(),
            ':subtotal'=>$venta->getSubtotal(), ':iva'=>$venta->getIva(), ':nombre'=>$venta->getNombre(),
            ':email'=>$venta->getEmail(), ':direccion'=>$venta->getDireccion(), ':nombreTarjeta'=>$venta->getNombreTarjeta(),
            'numTarjeta'=>$venta->getNumTarjeta());

        $estado = $conexion->actualizarBD($consulta, $parametros);
        $conexion->cerrarBD();

        // Procesamos cada línea del carrito
        foreach ($_SESSION['carrito'] as $key => $value) {
            if (($value[0] != null)) {
                $instrumento = $value[0];
                $cantidad = $value[1];

                $conexion->abrirBD();

                $consulta = "insert into lineasventas (idVenta, idProducto, distribuidor, tipo, precio, cantidad) 
                    values (:idVenta, :idProducto, :distribuidor, :tipo, :precio, :cantidad)";

                $parametros = array(':idVenta' => $venta->getId(), ':idProducto' => $instrumento->getId(),
                    ':distribuidor' => $instrumento->getdistribuidor(), ':tipo' => $instrumento->gettipo(), ':precio' => $instrumento->getPrecio(),
                    ':cantidad' => $cantidad);

                $estado = $conexion->actualizarBD($consulta, $parametros);

                // Actualizo el stock
                $cp = ControladorInstrumento::getControlador();
                $estado = $cp->actualizarStock($instrumento->getId(), ($instrumento->getstockinicial() - $cantidad));

            $conexion->cerrarBD();
        }
    }
        return $estado;
    }

}
<?php
//Directorios de trabajo
require_once MODEL_PATH."pago.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once UTILITY_PATH."funciones.php";

//Creamos el controlador que nos permitira acceder a las funciones para el proceso del pago
class Controladorpago{
    static private $instancia= null;
    private function __construct(){

    }
    public static function getControlador(){
        if(self::$instancia==null){
            self::$instancia=new Controladorpago();
        }
        return self::$instancia;
    }
// ----------------------------------------------Funcion para almacenar el pago-----------------------------------------------
public function almacenarpago($titular,$tarjeta_completa,$fecha,$cv){
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta= "INSERT INTO pago (titularcredit, tarjeta_completa, fechaexp, codigocv) VALUES (:titularcredit, :tarjeta_completa, :fechaexp, :codigocv)";
        $parametros= array(':titularcredit'=>$titular, ':tarjeta_completa'=>$tarjeta_completa, ':fechaexp'=>$fecha, ':codigocv'=>$cv);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
//-----------------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------Funcion para almacenar carrito-----------------------------------------------
public function almacenarcarrrito($nombre,$distribuidor,$precio,$cantidad){
    $bd = ControladorBD::getControlador();
    $bd->abrirBD();
    $consulta= "INSERT INTO carrito (nombre, distribuidor, precio, cantidad) VALUES (:nombre, :distribuidor, :precio, :cantidad)";
    $parametros= array(':nombre'=>$nombre, ':distribuidor'=>$distribuidor, ':precio'=>$precio, ':cantidad'=>$cantidad);
    $estado = $bd->actualizarBD($consulta,$parametros);
    $bd->cerrarBD();
    return $estado;
}
//-----------------------------------------------------------------------------------------------------------------------------

}
?>
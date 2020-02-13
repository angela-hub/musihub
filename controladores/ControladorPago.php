<?php
require_once MODEL_PATH."pago.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once UTILITY_PATH."funciones.php";

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
public function almacenarpago($titular,$tarjeta_completa,$fecha,$cv){
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta= "INSERT INTO instrumentos VALUES (:titularcredit, :numcredit, :fechaexp, :codigocv)";
        $parametros= array(':titularcredit'=>$titular, ':numcredit'=>$tarjeta_completa, ':fechaexp'=>$fecha, ':codigocv'=>$cv);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
}
}
?>
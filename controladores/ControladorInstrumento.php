<?php
require_once MODEL_PATH."instrumento.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once UTILITY_PATH."funciones.php";

class ControladorInstrumento {

    static private $instancia = null;
    private function __construct() {
        //echo "Conector creado";
    }
    
    /**
     * Patrón Singleton. Ontiene una instancia del Manejador de la BD
     * @return instancia de conexion
     */
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorInstrumento();
        }
        return self::$instancia;
    }
    
    /**
     * Lista los instrumentos según el nombre o referencia
     * @param type $nombre
     * @param type $referencia
     */
//----------------------------------------------------------------------------------------------------
    public function listarInstrumento($nombre, $referencia){
        $lista=[];
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();

        $consulta = "SELECT * FROM instrumentos WHERE nombre LIKE :nombre OR referencia LIKE :referencia";
        $parametros = array(':nombre' => "%".$nombre."%", ':referencia' => "%".$referencia."%");

        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);

        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $instrumento = new instrumento($a->id, $a->nombre, $a->referencia, $a->compañiadistribuidor, $a->tipo, $a->precio, $a->descuento, $a->stockinicial, $a->imagen);
                $lista[] = $instrumento;
            }
            $bd->cerrarBD();
            return $lista;
        }else{
            return null;
        }    
    }
//----------------------------------------------------------------------------------------------------
    public function almacenarInstrumento($nombre, $referencia, $compañiadistribuidor, $tipo, $precio, $descuento, $stockinicial, $imagen){
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "INSERT INTO instrumentos (nombre, referencia, compañiadistribuidor, tipo, precio, descuento, stockinicial, imagen) 
        VALUES ( :nombre, :referencia, :compañiadistribuidor, :tipo, :precio, :descuento, :stockinicial, :imagen)";
        
        $parametros= array( ':nombre'=>$nombre, ':referencia'=>$referencia, ':compañiadistribuidor'=>$compañiadistribuidor,':tipo'=>$tipo,
                            ':precio'=>$precio, ':descuento'=>$descuento, ':stockinicial'=>$stockinicial, ':imagen'=>$imagen);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
//----------------------------------------------------------------------------------------------------
    public function buscarInstrumentoRef($referencia){ 
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT* FROM instrumentos WHERE referencia = :referencia";
        $parametros = array(':referencia' => $referencia);
        $filas = $bd->consultarBD($consulta, $parametros);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $instrumento = new instrumento($a->id, $a->nombre, $a->referencia, $a->compañiadistribuidor, $a->tipo, $a->precio, $a->descuento, $a->stockinicial, $a->imagen);
            }
            $bd->cerrarBD();
            return $instrumento;
        }else{
            return null;
        }    
    }
//--------------------------------------------------------------------------------------------------
    public function buscarInstrumentoNom($nombre){ 
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT * FROM instrumentos  WHERE nombre = :nombre";
        $parametros = array(':nombre' => $nombre);
        $filas = $bd->consultarBD($consulta, $parametros);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $instrumento = new instrumento($a->id, $a->nombre, $a->referencia, $a->compañiadistribuidor, $a->tipo, $a->precio, $a->descuento, $a->stockinicial, $a->imagen);
            }
            $bd->cerrarBD();
            return $instrumento;
        }else{
            return null;
        }    
    }
//------------------------------------------------------------------------------------------------- 
    public function borrarInstrumento($id){ 
        $estado=false;
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "DELETE FROM instrumentos WHERE id = :id";
        $parametros = array(':id' => $id);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
//-------------------------------------------------------------------------------------------------  
    public function actualizarInstrumento($id ,$nombre, $referencia, $compañiadistribuidor, $tipo, $precio, $descuento, $stockinicial, $imagen){
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "UPDATE instrumentos SET  nombre=:nombre, referencia=:referencia, compañiadistribuidor=:compañiadistribuidor, tipo=:tipo, precio=:precio, 
            descuento=:descuento, stockinicial=:stockinicial, imagen=:imagen 
            WHERE id=:id";
        $parametros= array(':id' => $id, ':nombre'=>$nombre, ':referencia'=>$referencia, ':compañiadistribuidor'=>$compañiadistribuidor,':tipo'=>$tipo,
                            ':precio'=>$precio, ':descuento'=>$descuento, ':stockinicial'=>$stockinicial, ':imagen'=>$imagen);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
    
}
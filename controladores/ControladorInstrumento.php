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
// con la funcion listarInstrumentos buscaremos en la base de datos todos los instrumentos que se encuentren con el nombre que se le pase a la funcion
    public function listarInstrumentos($nombre){
        $lista=[];
        $bd=ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta="SELECT * FROM instrumentos WHERE nombre LIKE :nombre";
        $parametros=array(':nombre'=>"%".$nombre."%");
        $res=$bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);

        if(count($filas)>0){
            foreach($filas as $c){
                $instrumento=new instrumento($c->id,$c->nombre,$c->referencia,$c->distribuidor,$c->tipo,$c->precio,$c->descuento,$c->stockinicial,$c->imagen);
                $lista[]=$instrumento;
            }
            $bd->cerrarBD();
            return $lista;
        }else{
            return null;
        }
    }
//--------------------------------------------------------------------------------------------
// con la funcion listarInstrumento la cual buscara en la base de datos todos los instrumentos que se encuentren con el nombre que se le pase a la funcion
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
                $instrumento = new instrumento($a->id, $a->nombre, $a->referencia, $a->distribuidor, $a->tipo, $a->precio, $a->descuento, $a->stockinicial, $a->imagen);
                $lista[] = $instrumento;
            }
            $bd->cerrarBD();
            return $lista;
        }else{
            return null;
        }    
    }
//----------------------------------------------------------------------------------------------------
// con la funcion almacenarInstrumento la cual insertara en la base de datos un usuario con los parámetros pasados en la funcion
    public function almacenarInstrumento($nombre, $referencia, $distribuidor, $tipo, $precio, $descuento, $stockinicial, $imagen){
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "INSERT INTO instrumentos (nombre, referencia, distribuidor, tipo, precio, descuento, stockinicial, imagen) 
        VALUES ( :nombre, :referencia, :distribuidor, :tipo, :precio, :descuento, :stockinicial, :imagen)";
        
        $parametros= array( ':nombre'=>$nombre, ':referencia'=>$referencia, ':distribuidor'=>$distribuidor,':tipo'=>$tipo,
                            ':precio'=>$precio, ':descuento'=>$descuento, ':stockinicial'=>$stockinicial, ':imagen'=>$imagen);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
//----------------------------------------------------------------------------------------------------
// Creamos la funcion buscarInstrumentoId para buscar en la base de datos un instrumento con el id que se le pase a la funcion
        public function buscarInstrumentoId($id)
        {
            $bd = ControladorBD::getControlador();
            $bd->abrirBD();
            $consulta = "select * from instrumentos where id = :id";
            $parametros = array(':id' => $id);

            $res = $bd->consultarBD($consulta, $parametros);
            $filas = $res->fetchAll(PDO::FETCH_OBJ);

            if (count($filas) > 0) {
                $instrumento = new Instrumento($filas[0]->id, $filas[0]->nombre, $filas[0]->referencia, $filas[0]->distribuidor, $filas[0]->tipo,
                    $filas[0]->precio, $filas[0]->descuento, $filas[0]->stockinicial, $filas[0]->imagen);
                $bd->cerrarBD();
                return $instrumento;
            } else {
                return null;
            }
        }
//--------------------------------------------------------------------------------------------------
// Creamos la funcion buscarnombre para buscar en la base de datos si existe el nombre de un instrumento y ya este insertado
public function buscarNombre($id){
    $bd= ControladorBD::getControlador();
    $bd->abrirBD();
    $consulta="SELECT * FROM instrumentos WHERE id = :id";
    $parametros=array(':id'=>$id);
    $filas= $bd->consultarBD($consulta,$parametros);
    $res=$bd->consultarBD($consulta,$parametros);
    $filas=$res->fetchAll(PDO::FETCH_OBJ);
    if (count($filas)>0){
        foreach($filas as $c) {
            $instrumento = new Instrumento($filas[0]->id, $filas[0]->nombre, $filas[0]->referencia, $filas[0]->distribuidor, $filas[0]->tipo,
            $filas[0]->precio, $filas[0]->descuento, $filas[0]->stockinicial, $filas[0]->imagen);
            $nombre=$instrumento->getnombre();
        }
        $bd->cerrarBD();
        return $nombre;
    }else{
        return null;
    }
}
//--------------------------------------------------------------------------------------------------
// Creamos la funcion buscarInstrumentoNom para buscar en la base de datos un instrumento con el nombre que se le pase a la funcion

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
                $instrumento = new instrumento($a->id, $a->nombre, $a->referencia, $a->distribuidor, $a->tipo, $a->precio, $a->descuento, $a->stockinicial, $a->imagen);
            }
            $bd->cerrarBD();
            return $instrumento;
        }else{
            return null;
        }    
    }
    //--------------------------------------------------------------------------------------------------
// Creamos la funcion buscarRef para buscar en la base de datos si hay referencias iguales ya almacenadas

public function buscarRef($referencia){ 
    $bd = ControladorBD::getControlador();
    $bd->abrirBD();
    $consulta = "SELECT * FROM instrumentos  WHERE referencia = :referencia";
    $parametros = array(':referencia' => $referencia);
    $filas = $bd->consultarBD($consulta, $parametros);
    $res = $bd->consultarBD($consulta,$parametros);
    $filas=$res->fetchAll(PDO::FETCH_OBJ);
    if (count($filas) > 0) {
        foreach ($filas as $a) {
            $instrumento = new instrumento($a->id, $a->nombre, $a->referencia, $a->distribuidor, $a->tipo, $a->precio, $a->descuento, $a->stockinicial, $a->imagen);
        }
        $bd->cerrarBD();
        return $instrumento;
    }else{
        return null;
    }    
}
//------------------------------------------------------------------------------------------------- 
//Creamos la funcion borrarInstrumento con el id pasado a la tabla de instrumentos para eliminarlo
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
    public function actualizarInstrumento($id ,$nombre, $referencia, $distribuidor, $tipo, $precio, $descuento, $stockinicial, $imagen){
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "UPDATE instrumentos SET  nombre=:nombre, referencia=:referencia, distribuidor=:distribuidor, tipo=:tipo, precio=:precio, 
            descuento=:descuento, stockinicial=:stockinicial, imagen=:imagen 
            WHERE id=:id";
        $parametros= array(':id' => $id, ':nombre'=>$nombre, ':referencia'=>$referencia, ':distribuidor'=>$distribuidor,':tipo'=>$tipo,
                            ':precio'=>$precio, ':descuento'=>$descuento, ':stockinicial'=>$stockinicial, ':imagen'=>$imagen);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
//--------------------------------------------------------------------------------------------
//Creamos la funcion actualizarStock con la que actualizaremos los datos con los parametros pasados de un usuario el cual lo cogera por la id del usuario
    public function actualizarStock($id, $stock)
    {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();

        $consulta = "update instrumentos set stockinicial=stockinicial-:stock where id=:id";
        $parametros = array(':id' => $id, ':stock' => $stock);
        $estado = $bd->actualizarBD($consulta, $parametros);
        $bd->cerrarBD();
        return $estado;

        $conexion->cerrarBD();
        return $estado;
    }
    
}

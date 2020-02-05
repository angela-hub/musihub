<?php
// Datos de logueo para la base de datos -- modificable
class ControladorBD{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "music";
    private $server ="mysql";

    private $bd;
    private $rs;
    private $st;

    static private $instancia=null;
    
    private function __construct(){

    }

    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorBD();
        }
        return self::$instancia;
    }
// funcion para abrir  la base de datos -------------------------------------------------------------------------------------
    public function abrirBD(){
        try{
            $this->bd = new PDO($this->server.":host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("conexión fallida " . $e->getMessage());
        }
    }
// funcion para cerrar la base da datos -------------------------------------------------------------------------------------
    public function cerrarBD() {
        $this->bd=null;
        $this->rs=null;
        $this->st=null;
    }
// funciones para actualizar la base datos --------------------------------------------------------------------------------------
    public function actualizarBD($consulta, $parametros=null) {
        if($parametros!=null)
            return $this->actualizarBDParametros($consulta,$parametros);
        else
            return $this->actualizarBDDirecta($consulta);
    }
    
    private function actualizarBDDirecta($consulta){
        if ($this->bd->exec($consulta) != 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function actualizarBDParametros($consulta, $parametros){
        $this->st = $this->bd->prepare($consulta);
        return $this->st->execute($parametros);
    }

    public function consultarBD($consulta, $parametros=null){
        if($parametros!=null)
            return $this->consultarBDParametros($consulta,$parametros);
        else
            return $this->consultarBDDirecta($consulta);
            
    }

    private function consultarBDDirecta($consulta) {
        $this->rs = $this->bd->query($consulta);
        return $this->rs;
    }

    private function consultarBDParametros($consulta, $parametros) {
        $this->st = $this->bd->prepare($consulta);
        $this->st->execute($parametros);
        return $this->st;
    }
// funcion con los datos de conexion de la base de datos -------------------------------------------------------------
    public function datosConexion() {
        return $this->servername;
    }

    private function alerta($texto) {
        echo '<script type="text/javascript">alert("' . $texto . '")</script>';
    }
}

?>
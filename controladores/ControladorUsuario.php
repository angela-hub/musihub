<?php

require_once MODEL_PATH."usuario.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once UTILITY_PATH."funciones.php";

class ControladorUsuario{
    static private $instancia= null;
    private function __construct(){

    }
    public static function getControlador(){
        if(self::$instancia==null){
            self::$instancia=new ControladorUsuario();
        }
        return self::$instancia;
    }
    public function listarUsuarios($nombre){
        $lista=[];
        $bd=ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta="SELECT * FROM usuarios WHERE nombre LIKE :nombre";
        $parametros=array(':nombre'=>"%".$nombre."%");
        $res=$bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);

        if(count($filas)>0){
            foreach($filas as $c){
                $usuario=new usuario($c->id,$c->nombre,$c->apellidos,$c->email,$c->password,$c->administrador,$c->telefono,$c->fecha_alta,$c->foto);
                $lista[]=$usuario;
            }
            $bd->cerrarBD();
            return $lista;
        }else{
            return null;
        }
    }
    public function almacenarUsuario($nombre,$apellidos,$email,$password,$administrador,$telefono,$fecha_alta,$foto){
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta= "INSERT INTO usuarios (nombre, apellidos, email, password, administrador, telefono, fecha_alta, foto) VALUES (:nombre, :apellidos, :email, :password, :administrador, :telefono, :fecha_alta, :foto)";
        $parametros= array(':nombre'=>$nombre, ':apellidos'=>$apellidos, ':email'=>$email, ':password'=>$password, 
        ':administrador'=>$administrador, ':telefono'=>$telefono, ':fecha_alta'=>$fecha_alta, ':foto'=>$foto);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
        /*
        $consulta2="SELECT count(nombre) FROM usuarios where nombre=:nombre";
        $parametros2=array(':nombre' => $nombre);
        $result= $bd->consultarBD($consulta2, $parametros2);
    
        $row= $result->fetch(PDO::FETCH_NUM);
        
        if($row[0] == 0){
            $estado=$bd->actualizarBD($consulta,$parametros);
            $bd->cerrarBD();
            return $estado;
        }else if($row[0] == 1){
            echo ("ERROR: Ya hay un Usuario llamado ". $nombre. "en la lista");
            exit();
        }else{
            return null;
            exit();
        }
        */
    }
    
    public function buscarUsuario($id){
        $bd= ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta="SELECT * FROM usuarios WHERE id = :id";
        $parametros=array(':id'=>$id);
        $filas= $bd->consultarBD($consulta,$parametros);
        $res=$bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas)>0){
            foreach($filas as $c) {
                $usuario=new usuario($c->id,$c->nombre,$c->apellidos,$c->email,$c->password,$c->administrador,$c->telefono,$c->fecha_alta,$c->foto);
            }
            $bd->cerrarBD();
            return $usuario;
        }else{
            return null;
        }
    }
    
    public function buscarUsuarioEmail($email){
        $bd= ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta="SELECT * FROM usuarios WHERE email = :email";
        $parametros=array(':email'=>$email);
        $filas= $bd->consultarBD($consulta,$parametros);
        $res=$bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas)>0){
            foreach($filas as $c) {
                $usuario=new usuario($c->id,$c->nombre,$c->apellidos,$c->email,$c->password,$c->administrador,$c->telefono,$c->fecha_alta,$c->foto);
            }
            $bd->cerrarBD();
            return $usuario;
        }else{
            return null;
        }
    }
    
    public function borrarUsuario($id){
        $estado=false;
        $bd= ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta= "DELETE FROM usuarios WHERE id=:id";
        $parametros=array(':id'=>$id);
        $estado=$bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
    
    public function actualizarUsuario($id,$nombre,$apellidos,$email,$administrador,$telefono,$fecha_alta,$foto){
        $bd=ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta="UPDATE usuarios SET nombre=:nombre, apellidos=:apellidos, email=:email, administrador=:administrador, telefono=:telefono, fecha_alta=:fecha_alta, foto=:foto WHERE id=:id";
        $parametros= array(':id' => $id, ':nombre'=>$nombre,':apellidos'=>$apellidos,':email'=>$email,':administrador'=>$administrador,':telefono'=>$telefono,':fecha_alta'=>$fecha_alta,':foto'=>$foto);
        $estado= $bd-> actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
}

?>
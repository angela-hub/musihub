<?php

require_once MODEL_PATH."usuario.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once UTILITY_PATH."funciones.php";
//--------------------------------------------------------------------------------------------
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
    //--------------------------------------------------------------------------------------------
    // Creamos la funcion listarUsuarios la cual buscara en la base de datos todos los usuarios que se encuentren con el nombre que se le pase a la funcion
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
    //-------------------------------------------------------------------------------------------- 
    // Creamos la funcion almacenar usuario la cual insertara en la base de datos un usuario con los parámetros pasados en la funcion
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
    //-------------------------------------------------------------------------------------------- 
    // Creamos la funcion buscarUsuario para buscar en la base de datos un usuario con la id que se le pase a la funcion
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
//-------------------------------------------------------------------------------------------- 
    //Esta funcion es igual que la anterior pero la hemos adaptado para coger el email que tiene ese usuario
    public function buscarUsuarioE($id){
        $bd= ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta="SELECT * FROM usuarios WHERE id = :id";
        $parametros=array(':id'=>$id);
        $filas= $bd->consultarBD($consulta,$parametros);
        $res=$bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas)>0){
            foreach($filas as $c) {
                $usuario = new usuario($filas[0]->id, $filas[0]->nombre, $filas[0]->apellidos, $filas[0]->email, $filas[0]->password, $filas[0]->administrador, $filas[0]->telefono, $filas[0]->fecha_alta, $filas[0]->foto);
                $email=$usuario->getemail();
            }
            $bd->cerrarBD();
            return $email;
        }else{
            return null;
        }
    }
    //--------------------------------------------------------------------------------------------
    //Creamos la funcion para buscarun usuario a traves de un email en vez del nombre pasandole el email a través de la funcion
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
    //--------------------------------------------------------------------------------------------
    //Creamos la funcion borrar usuario con la id pasada de la tabla usuarios
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
    //-------------------------------------------------------------------------------------------- 
    //Creamos la funcion actualizarUsuario la cual actualizara los datos de los parametros pasados de un usuario el cual lo cogera por la id del usuario
    public function actualizarUsuario($id,$nombre,$apellidos,$email,$administrador,$telefono,$fecha_alta,$foto){
        $bd=ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta="UPDATE usuarios SET nombre=:nombre, apellidos=:apellidos, email=:email, administrador=:administrador, telefono=:telefono, fecha_alta=:fecha_alta, foto=:foto WHERE id=:id";
        $parametros= array(':id' => $id, ':nombre'=>$nombre,':apellidos'=>$apellidos,':email'=>$email,':administrador'=>$administrador,':telefono'=>$telefono,':fecha_alta'=>$fecha_alta,':foto'=>$foto);
        $estado= $bd-> actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
    //--------------------------------------------------------------------------------------------
    //Creamos la funcion actualizarUsuarioN en la cual actualizaremos un usuario como la anterior vez pero esta vez los parámetros que se actualizaran seran distintos
    // ya que lo utilizaremos para otro proposito diferente a la anterior
    public function actualizarUsuarioN($id, $nombre, $apellidos, $email, $password, $telefono, $foto){
        $bd=ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta="UPDATE usuarios SET nombre=:nombre, apellidos=:apellidos, email=:email, password=:password, telefono=:telefono, foto=:foto WHERE id=:id";
        $parametros= array(':id' => $id, ':nombre'=>$nombre,':apellidos'=>$apellidos,':email'=>$email,':password'=>$password,':telefono'=>$telefono,':foto'=>$foto);
        $estado= $bd-> actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
}

?>
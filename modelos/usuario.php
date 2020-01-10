<?php
class usuario {
    private $id;
    private $nombre;
    private $apellidos;
    private $email;
    private $password;
    private $administrador;
    private $telefono;
    private $fecha_alta;
    private $foto;

    
    // Constructor
    public function __construct($id, $nombre, $apellidos, $email, $password, $administrador, $telefono, $fecha_alta, $foto) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->password = $password;
        $this->administrador = $administrador;
        $this->telefono = $telefono;
        $this->fecha_alta = $fecha_alta;
        $this->foto = $foto;
    }
    
    //GETS
    function getid() {
        return $this->id;
    }

    function getnombre() {
        return $this->nombre;
    }

    
    function getapellidos() {
        return $this->apellidos;
    }

    function getemail() {
        return $this->email;
    }

    function getpassword() {
        return $this->password;
    }

    function getadministrador() {
        return $this->administrador;
    }

    function gettelefono() {
        return $this->telefono;
    }

    function getfecha_alta() {
        return $this->fecha_alta;
    }

    function getfoto() {
        return $this->foto;
    }

    //SETS

    function setid($id) {
        $this->id = $id;
    }

    function setnombre($nombre) {
        $this->nombre = $nombre;
    }

    function setapellidos($apellidos) {
        $this->apellidos = $apellidos;
    }
    
    function setemail($email) {
        $this->email = $email;
    } 

    function setpassword($password) {
        $this->password = $password;
    } 

    function setadministrador($administrador) {
        $this->administrador = $administrador;
    } 

    function settelefono($telefono) {
        $this->telefono = $telefono;
    }
    
    function setfecha_alta($fecha_alta) {
        $this->fecha_alta = $fecha_alta;
    }

    function setfoto($foto) {
        $this->foto = $foto;
    } 
}
?>
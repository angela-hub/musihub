<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once CONTROLLER_PATH."ControladorBD.php";
require_once MODEL_PATH."usuario.php";

class ControladorAcceso {
    // Variable instancia para Singleton
    static private $instancia = null;
    
    // constructor--> Private por el patrón Singleton
    private function __construct() {
        //echo "Conector creado";
    }

    /**
     * Patrón Singleton. Ontiene una instancia de controlador
     * @return instancia del controlador
     */
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorAcceso();
        }
        return self::$instancia;
    }
    
    public function salirSesion() {
        // Recuperamos la información de la sesión
        session_start();
        // Y la eliminamos las variables de la sesión y coockies
        unset($_SESSION['USUARIO']);
        //unset($_COOKIE['CONTADOR']);
        // ahora o las borramos todas o las destruimos, yo haré todo para que se vea
        session_unset();
        session_destroy();
    }

    public function reiniciarsesion()
    {
        $_SESSION['uds'] = 0;
        $_SESSION['total'] = 0;
        $_SESSION['carrito'] = array();
    }
    
    
    public function procesarIdentificacion($email, $password){

            //borro la sesion, por gusto, no se debería hacer pues nos cargamos todas
           //$this->salirSesion();

            $password = hash('md5', $password);

            // Conectamos a la base de datos
            $bd = ControladorBD::getControlador();
            $bd->abrirBD();
            // creamos la consulta pero esta vez paremtrizada
            $consulta = "SELECT * FROM usuarios WHERE email=:email and password=:password";
            $parametros = array(':email' => $email, ':password' => $password);
            // Obtenemos las filas directamente como objetos con las columnas de la tabla
            $res = $bd->consultarBD($consulta,$parametros);
            $filas=$res->fetchAll(PDO::FETCH_OBJ);
            //var_dump($filas);
            if (count($filas) > 0) {
                 // abrimos las sesiones
                 session_start();
                 // Almacenamos el usuario en la sesion.
                 $usuario = new usuario($filas[0]->id, $filas[0]->nombre, $filas[0]->apellidos, $filas[0]->email, $filas[0]->password, $filas[0]->administrador, $filas[0]->telefono, $filas[0]->fecha_alta, $filas[0]->foto);
                 $_SESSION['id'] = $usuario->getid();
                 $_SESSION['nombre'] = $usuario->getnombre();
                $_SESSION['apellidos'] = $usuario->getapellidos();
                $_SESSION['administrador'] = $usuario->getadministrador();
                $_SESSION['email'] = $usuario->getemail();
                 $_SESSION['USUARIO']['email']=$email;

                 $_SESSION['uds'] = 0;
                $_SESSION['carrito'] = array();
                 //echo $_SESSION['USUARIO']['email'];
                 header("location: index.php"); 
                 exit();              
            } else {
                echo "<div class='wrapper'>";
                    echo "<div class='container-fluid'>";
                        echo "<div class='row'>";
                            echo "<div class='col-md-12'>";
                                echo "<div class='page-header'>";
                                     echo "<h1>Usuario/a incorrecto</h1>";
                                 echo "</div>";
                                echo "<div class='alert alert-warning fade in'>";
                                    echo "<p>Lo siento, el emial o password es incorrecto. Por favor <a href='login.php' class='alert-link'>regresa</a> e inténtelo de nuevo.</p>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                //<!-- Pie de la página web -->
                //require_once VIEW_PATH."pie.php";
                exit();
            }
    }

    public function reiniciarCarrito(){
        $_SESSION['uds'] = 0;
        $_SESSION['total'] = 0;
        $_SESSION['carrito'] = array();
    }

}

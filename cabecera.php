<?php
// directorios de trabajo y acceso necesario para la gestion de la cabecera  
require_once $_SERVER['DOCUMENT_ROOT']."/musihub/dirs.php";
require_once CONTROLLER_PATH."ControladorUsuario.php";
require_once CONTROLLER_PATH . "ControladorInstrumento.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once CONTROLLER_PATH . "Paginador.php";
require_once CONTROLLER_PATH . "ControladorAcceso.php";
require_once CONTROLLER_PATH . "ControladorCarrito.php";
require_once CONTROLLER_PATH . "ControladorVenta.php";
require_once UTILITY_PATH. "funciones.php";

//seguro para que obligue al administrador iniciar sesion 
session_start();
if(isset($_SESSION['USUARIO']['email'])){
    if($_SESSION['administrador'] == "si"){
        $admin="admin";
    }else{
        $admin="";
    }
}else{
    $admin="";
}
?>
<link rel="icon" type="image/png" href="logo.png">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/themify-icons.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="/musihub/css/style.css" type="text/css">
<header class="header-section">
        <div class="header-top">
        <?php    
        //Recoge la URL de la web y la almacena en la variable tipo
        $tipo=$_SERVER["REQUEST_URI"];
        //Comprueba si la variable tipo que tiene la URL coincide con lo que se le pasa a continuacion
            if (startsWith($tipo,"/musihub/carrito") || $tipo=="/musihub/admin/vistas_usuarios/listado_usu.php" || $tipo=="/musihub/admin/vistas_usuarios/listado_usu.php?limit=5&page=1" || $tipo=="/musihub/admin/vistas_instrumentos/listado.php" || $tipo=="/musihub/admin/vistas_instrumentos/listado.php?limit=5&page=1"){
                $tipo="";
                $estilo="width:99.24%";
            }else{
                $tipo="container";
                $estilo="";
            }
            $inicio=$_SERVER["REQUEST_URI"];
            echo "<div class='$tipo'>";
        ?>
                <div style="margin-left:5px;" class="ht-left">
                    <div class="mail-service">
                    <i class="glyphicon glyphicon-envelope"></i>
                        contacto@musihub.com
                    </div>
                    <div class="phone-service">
                        <i class="glyphicon glyphicon-earphone"></i>
                        +34 666 55 55 55
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-item">
            <?php
            echo "<div class='$tipo' style='$estilo'>";
            ?>
                <nav class="nav-menu mobile-menu">
                    <ul>
                    <?php
                        $inicio=$_SERVER["REQUEST_URI"];
                        if ($inicio=="/musihub/contacto.php"){
                            echo "<li><a href='/musihub/index.php'>Inicio</a></li>";
                            echo "<li class='active'><a href='/musihub/contacto.php'>Contacto</a></li>";
                            if($admin=="admin"){
                            echo "<li><a href='/musihub/admin/inicio.php'>Administración</a></li>";
                            }
                        }elseif(startsWith($inicio,"/musihub/index.php")){
                        //}elseif($inicio=="/musihub/index.php" || $inicio=="/musihub/index.php?limit=12&page=1" || $inicio=="/musihub/"){
                            echo "<li style='width:11%;' class='active'><a 'href='/musihub/index.php'>Inicio</a></li>";
                            echo "<li><a href='/musihub/contacto.php'>Contacto</a></li>";
                            if($admin=="admin"){
                            //startwidth
                            echo "<li><a href='/musihub/admin/inicio.php'>Administración</a></li>";
                            }
                            ?>
                            <li>
                                <form class="form-inline mt-2 mt-md-0" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <input class="form-control input-md" name="instrumento" type="text" placeholder="Buscar Instrumento">
                                    <button  class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                                </form>
                            </li>
                            <?php
                        }elseif(startsWith($inicio,"/musihub/admin")){
                            echo "<li><a href='/musihub/index.php'>Inicio</a></li>";
                            echo "<li><a href='/musihub/contacto.php'>Contacto</a></li>";
                            if($admin=="admin"){
                            echo "<li class='active'><a href='/musihub/admin/inicio.php'>Administración</a></li>";
                            }
                        }else{
                            echo "<li><a style='text-decoration:none;' href='/musihub/index.php'>Inicio</a></li>";
                            echo "<li><a style='text-decoration:none;' href='/musihub/contacto.php'>Contacto</a></li>";
                            if($admin=="admin"){
                            echo "<li><a style='text-decoration:none;' href='/musihub/admin/inicio.php'>Administración</a></li>";
                            }
                        }
                        if(!isset($_SESSION['cantidad']) || empty($_SESSION['cantidad'])){
                            $_SESSION['cantidad']=0;
                        }
                        if(!isset($_SESSION['precio']) || empty($_SESSION['precio'])){
                            $_SESSION['precio']=0;
                        }
                        if (!isset($_POST["instrumento"])) {
                            $referencia = "";
                            $nombre = "";
                        } else {
                            $referencia = filtrado($_POST["instrumento"]);
                            $nombre = filtrado($_POST["instrumento"]);
                        }
                            $controlador = ControladorInstrumento::getControlador();
                            $consulta = "SELECT * FROM instrumentos WHERE referencia LIKE :referencia OR nombre LIKE :nombre";
                            $parametros = array(':referencia' => "%" . $referencia . "%", ':referencia' => "%" . $referencia . "%", ':nombre' => "%" . $nombre . "%");
                            if(!isset($_SESSION['USUARIO']['email'])){
                                echo '<li style="width:13%;"class="nav navbar-nav navbar-right"><a style="padding:15px;" href="/musihub/registro.php"><span class="glyphicon glyphicon-user"></span> Registrarse</a></li>';
                                echo '<li style="width:10%;"class="nav navbar-nav navbar-right"><a style="padding:15px;" href="/musihub/login.php"><span class="glyphicon glyphicon-user"></span>  Login</a></li>';
                            }else{
                                //$to=ControladorCarrito::getControlador();
                                //Asignamos a la sesion total el precio total en carrito a la cual la llamaremos mas abajo
                                //$_SESSION['total'] = $to -> precioencarrito();
                                echo '<li style="width:15%;"class="nav navbar-nav navbar-right"><a style="padding:15px; text-decoration:none;" href="/musihub/area.php?id=' . encode($_SESSION['id']).'"><span class="glyphicon glyphicon-user"></span> '.$_SESSION['nombre'].'</a></li>';
                                echo '<li style="width:10%;"class="nav navbar-nav navbar-right"><a style="padding:15px; text-decoration:none;" href="/musihub/login.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>';
                                if($_SESSION['precio']==0){
                                    echo '<li style="width:11%;"class="nav navbar-nav navbar-right"><a style="padding:15px; text-decoration:none;" href="/musihub/carrito/resumen.php"><span class="glyphicon glyphicon-shopping-cart"></span> '.$_SESSION['cantidad'].'</a></li>';
                                }else{
                                    //Aqui llamamos a la sesion total
                                    echo '<li style="width:11.3%;"class="nav navbar-nav navbar-right"><a style="padding:15px; text-decoration:none;"href="/musihub/carrito/resumen.php"><span class="glyphicon glyphicon-shopping-cart"></span> '.$_SESSION['cantidad']. ' - '. $_SESSION['precio']. ' €'.'</a></li>';
                                }
                                //echo '<li style="width:9%; padding:15px; color:white;"class="nav navbar-nav navbar-right"><span class="glyphicon glyphicon-euro">'. " ".$_SESSION['total'] . '</span></li>';
                            }
                        ?>
                    </ul>
                </nav>
                <div id="mobile-menu-wrap"></div>
            </div>
        </div>
    </header>
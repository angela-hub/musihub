<?php
require_once $_SERVER['DOCUMENT_ROOT']."/musihub/dirs.php";
require_once CONTROLLER_PATH."ControladorUsuario.php";
require_once CONTROLLER_PATH . "ControladorInstrumento.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once CONTROLLER_PATH . "Paginador.php";
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
  if(isset($_COOKIE['CONTADOR']))
  { 
    // Caduca en un día
    setcookie('CONTADOR', $_COOKIE['CONTADOR'] + 1, time() + 24 * 60 * 60); // un día
    $contador = 'Número de visitas hoy: ' . $_COOKIE['CONTADOR']; 
  } 
  else 
  { 
    // Caduca en un día
    setcookie('CONTADOR', 1, time() + 24 * 60 * 60); 
    $cotador = 'Número de visitas hoy: 1'; 
  } 
  if(isset($_COOKIE['ACCESO']))
  { 
    // Caduca en un día
    setcookie('ACCESO', date("d/m/Y  H:i:s"), time() + 3 * 24 * 60 * 60); // 3 días
    $acceso = '<br>Último acceso: ' . $_COOKIE['ACCESO']; 
  } 
  else 
  { 
    // Caduca en un día
    setcookie('ACCESO', date("d/m/Y  H:i:s"), time() + 3 * 24 * 60 * 60); // 3 días
    $acceso = '<br>Último acceso: '. date("d/m/Y  H:i:s"); 
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
        $tipo=$_SERVER["REQUEST_URI"];
            if ($tipo=="/musihub/admin/vistas_usuarios/listado_usu.php" || $tipo=="/musihub/admin/vistas_usuarios/listado_usu.php?limit=5&page=1" || $tipo=="/musihub/admin/vistas_instrumentos/listado.php" || $tipo=="/musihub/admin/vistas_instrumentos/listado.php?limit=5&page=1"){
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
                        }elseif($inicio=="/musihub/index.php" || $inicio=="/musihub/index.php?limit=12&page=1" || $inicio=="/musihub/"){
                            echo "<li class='active'><a href='/musihub/index.php'>Inicio</a></li>";
                            echo "<li><a href='/musihub/contacto.php'>Contacto</a></li>";
                            if($admin=="admin"){
                            echo "<li><a href='/musihub/admin/inicio.php'>Administración</a></li>";
                            }
                            ?>
                            <li style="margin-left:50px;">
                                <form class="form-inline mt-2 mt-md-0" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <input class="form-control mr-sm-2" name="instrumento" type="text" placeholder="Buscar Instrumento">
                                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                                </form>
                            </li>
                            <?php
                        }else{
                            echo "<li><a href='/musihub/index.php'>Inicio</a></li>";
                            echo "<li><a href='/musihub/contacto.php'>Contacto</a></li>";
                            if($admin=="admin"){
                            echo "<li class='active'><a href='/musihub/admin/inicio.php'>Administración</a></li>";
                            }
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
                                echo '<li style="width:13%;"class="nav navbar-nav navbar-right"><a style="padding:15px;" href="#"><span class="glyphicon glyphicon-user"></span> Registrarse</a></li>';
                                echo '<li style="width:10%;"class="nav navbar-nav navbar-right"><a style="padding:15px;" href="/musihub/login.php"><span class="glyphicon glyphicon-user"></span>  Login</a></li>';
                            }else{
                                echo '<li style="width:15%;"class="nav navbar-nav navbar-right"><a style="padding:15px;" href="#"><span class="glyphicon glyphicon-user"></span> '.$_SESSION['nombre'].'</a></li>';
                                echo '<li style="width:10%;"class="nav navbar-nav navbar-right"><a style="padding:15px;" href="/musihub/login.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>';
                            }
                        ?>
                    </ul>
                </nav>
                <div id="mobile-menu-wrap"></div>
            </div>
        </div>
    </header>
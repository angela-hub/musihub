<?php
require_once $_SERVER['DOCUMENT_ROOT']."/musihub/dirs.php";
require_once CONTROLLER_PATH."ControladorUsuario.php";
require_once CONTROLLER_PATH . "ControladorInstrumento.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once CONTROLLER_PATH . "Paginador.php";
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
            <div class="container">
                <div class="ht-left">
                    <div class="mail-service">
                        <i class=" fa fa-envelope"></i>
                        contacto@musihub.com
                    </div>
                    <div class="phone-service">
                        <i class=" fa fa-phone"></i>
                        +65 11.188.888
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-item">
            <div class="container">
                <nav class="nav-menu mobile-menu">
                    <ul>
                    <?php
                        $inicio=$_SERVER["REQUEST_URI"];
                        if ($inicio=="/musihub/contacto.php"){
                            echo "<li><a href='./index.php'>Inicio</a></li>";
                            echo "<li class='active'><a href='./contacto.php'>Contacto</a></li>";
                        }else{
                            echo "<li class='active'><a href='./index.php'>Inicio</a></li>";
                            echo "<li><a href='./contacto.php'>Contacto</a></li>";
                        }
                    ?>
                        <li><a href="admin/inicio.php">Administración</a></li>
                        <li>
                            <form class="form-inline mt-2 mt-md-0" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <input class="form-control mr-sm-2" name="instrumento" type="text" placeholder="Buscar Instrumento">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                            </form>
                        </li>
                        <?php
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
                        ?>
                        <li class="nav navbar-nav navbar-right"><a href="#"><span class="glyphicon glyphicon-user"></span>  Login</a></li>
                    </ul>
                </nav>
                <div id="mobile-menu-wrap"></div>
            </div>
        </div>
    </header>
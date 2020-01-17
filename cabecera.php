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
                        <li ><a href="/musihub/index.php">Inicio</a></li>
                        <li><a href="./contacto.php">Contacto</a></li>
                        <li><a href="admin/inicio.php">Administración</a></li>
                        <li>
                            <form class="form-inline mt-2 mt-md-0" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <input class="form-control mr-sm-2" name="instrumento" type="text" placeholder="Büscar Instrumento">
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
                        <li style='float:right'><a href="#"><span class="glyphicon glyphicon-user"></span>  Login</a></li>
                    </ul>
                </nav>
                <div id="mobile-menu-wrap"></div>
            </div>
        </div>
    </header>
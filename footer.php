<!------ FOOTER ---------->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style type="text/css">
        .footer {
            position: relative;
            background-color: #3d3d3d;
            color: #c5c5c5;
            z-index: 10001;
            padding: 55px 0 40px;
        }
        
        h5 {
            font-size: 18px;
            font-weight: 700;
            font-family: 'Open Sans', sans-serif;
            color: #fff;
            position: relative;
            padding-bottom: 16px;
        }
        
        h5:after {
            content: '';
            display: block;
            margin: 15px 0 0;
            width: 40px;
            height: 1px;
            background-color: #86c200;
        }
        
        .footer ul {
            list-style: none;
            line-height: 2.8em;
        }
        
        .footer ul a {
            color: #c5c5c5;
        }
        
        .footer ul a:hover {
            color: #86c200;
        }
    </style>
</head>

<body>
    <div class="footer">
        <div class="container">
            <div class="col-md-3 footer-one">
                <img src="http://xena.tonytemplates.com/themeforest/lawn-service/images/guarantee.png" class="img-responsive" alt="">
            </div>
            <?php
            if(isset($_SESSION['USUARIO']['email'])){
                if($_SESSION['administrador'] == "si"){
            ?>
            <div class="col-md-3 footer-two">
                <h5>Administración</h5>
                <ul>
                    <li><a href="/musihub/admin/vistas_usuarios/listado_usu.php">Gestión de Usuarios</a></li>
                    <li><a href="/musihub/admin/vistas_instrumentos/listado.php">Gestión de Instrumentos</a></li>
                </ul>
            </div>
            <?php
            }
        }
            ?>
            <div class="col-md-3 footer-three">
                <h5>Information</h5>
                <ul>
                    <li><a href="/musihub/index.php">Tienda</a></li>
                    <li><a href="/musihub/contacto.php">Contacto</a></li>
                    <li><a href="sobre_nosotros.html">Sobre nosotros</a></li>
                </ul>
            </div>
            <div class="col-md-3 footer-four">
                <h5>Social Network</h5>
                <ul>
                    <li><a href="https://www.instagram.com/?hl=es">Instagram</a></li>
                    <li><a href="https://es-es.facebook.com/">Facebook</a></li>
                    <li><a href="https://www.linkedin.com/">Linkedin</a></li>
                    <li><a href="https://www.whatsapp.com/">Whatsapp</a></li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</body>

</html>
<?php
/*session_start();
print_r($_SESSION['carrito']);
exit();
*/
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Musihub</title>
        <link rel="icon" type="image/png" href="logo.png">
	</head>
	<body>

        <?php
        //cabecera de incio
        require_once "cabecera.php";
        ?>
		<br />
		<div class="container">
			<br />
			<br />
			<br />
            <?php
            // desarrollo para la creacion de catalogo de productos
            if (!isset($_POST["instrumento"])) {
                $referencia = "";
                $nombre = "";
            } else {
                $referencia = filtrado($_POST["instrumento"]);
                $nombre = filtrado($_POST["instrumento"]);
            }
            $controlador = ControladorInstrumento::getControlador();

            $pagina = (isset($_GET['page'])) ? $_GET['page'] : 1;
            $enlaces = (isset($_GET['enlaces'])) ? $_GET['enlaces'] : 10;

            $consulta = "SELECT * FROM instrumentos WHERE stockinicial > '0' and (referencia LIKE :referencia OR nombre LIKE :nombre)";
            $parametros = array(':referencia' => "%" . $referencia . "%", ':referencia' => "%" . $referencia . "%", ':nombre' => "%" . $nombre . "%");
            $limite = 12; // Limite
            $paginador  = new Paginador($consulta, $parametros, $limite);
            $resultados = $paginador->getDatos($pagina);
            foreach ($resultados->datos as $a) {
            $instrumento = new instrumento($a->id, $a->nombre, $a->referencia, $a->distribuidor, $a->tipo, $a->precio, $a->descuento, $a->stockinicial, $a->imagen);
            ?>

            <!--------------------------- Pintamos el catalogo mostrando nombre y precio del producto----------------------------->

            <div class="col-md-3">
                   <form method='post' action='index.php?action=add&id=<?php echo $instrumento->getid(); ?>'>
                    <div style=' border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;' align="center">
                        <img style='height:200px;' src='imagenes/fotos/<?php echo $instrumento->getimagen() ?>' class='img-responsive' /><br />

                        <h4 class='text-info'><?php echo $instrumento->getnombre(); ?></h4>

                        <h4 class='text-danger'><?php echo $instrumento->getprecio(); ?> €</h4>

                        <br><br>

                
                        <?php
                        // si el usuario no esta logueado no tiene accesso a añadir productos al carrito
                        if (isset($_SESSION['USUARIO']['email'])) {
                            echo "<a style='margin-right:5px;' class='btn btn-principal btn-success' href='/musihub/carrito/añadircarrito.php?id=" . encode($instrumento->getId()) . "&page=" . encode("/musihub/index.php") . "' title='Añadir' data-toggle='tooltip'>Añadir<span class='glyphicon glyphicon-shopping-cart'></span></a>";
                        } else {
                            echo "<a style='margin-right:5px;' class='btn btn-principal btn-success' href='/musihub/login.php' title='Añadir' data-toggle='tooltip'>Añadir<span class='glyphicon glyphicon-shopping-cart'></span></a>";
                        }
                        echo "<a style='margin-left:5px;' class='btn btn-principal btn-info' href='catalogo/read_catalogo.php?id=" . encode($instrumento->getid()) . "' title='Informacion' data-toggle='tooltip'>Detalles<span class='glyphicon glyphicon-list-alt'></span></a>";
                        ?>
                        
                    </div>
                    <br>
                </form>
            </div>
            <?php
                }
            ?>
        </div>
        <?php
            echo $paginador->crearLinks($enlaces);
        ?>
        <br>
        <br>
        <br>
        <?php require_once "footer.php";?>
	</body>
</html>
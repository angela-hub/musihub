<?php
require_once $_SERVER['DOCUMENT_ROOT']."/musihub/dirs.php";
require_once CONTROLLER_PATH."ControladorUsuario.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once CONTROLLER_PATH . "Paginador.php";

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Musihub</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container">
			<br />
			<br />
			<br />
			<br /><br />
			<?php
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

            $consulta = "SELECT * FROM instrumentos WHERE referencia LIKE :referencia OR nombre LIKE :nombre";
            $parametros = array(':referencia' => "%" . $referencia . "%", ':referencia' => "%" . $referencia . "%", ':nombre' => "%" . $nombre . "%");
            $limite = 20; // Limite
            $paginador  = new Paginador($consulta, $parametros, $limite);
            $resultados = $paginador->getDatos($pagina);
            foreach ($resultados->datos as $a) {
            $instrumento = new instrumento($a->id, $a->nombre, $a->referencia, $a->distribuidor, $a->tipo, $a->precio, $a->descuento, $a->stockinicial, $a->imagen);
            ?>
            <div class="col-md-3">
                <form method='post' action='index.php?action=add&id=<?php echo $instrumento->getid(); ?>'>
                    <div style=' border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;' align="center">
                        <img style='height:200px;' src='imagenes/fotos/<?php echo $instrumento->getimagen() ?>' class='img-responsive' /><br />

                        <h4 class='text-info'><?php echo $instrumento->getnombre(); ?></h4>

                        <h4 class='text-danger'><?php echo $instrumento->getprecio(); ?> €</h4>

                        <input id='number' type='number' value='1' min='1'>
                        <br><br>
                        <?php
                        echo "<a class='btn btn-info btn-lg' href='catalogo/carrito.php?id=" . encode($instrumento->getid()) . "' title='add' data-toggle='tooltip'>Añadir<span class='glyphicon glyphicon-shopping-cart'></span></a>";
                        echo "<a class='btn btn-info btn-lg' href='catalogo/read_catalogo.php?id=" . encode($instrumento->getid()) . "' title='info' data-toggle='tooltip'>Detalles<span class='glyphicon glyphicon-list-alt'></span></a>";
                        ?>
                    </div>
                </form>
            </div>
            <?php
            }
            ?>
		</div>
	</body>
</html>
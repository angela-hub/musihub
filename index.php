<!DOCTYPE html>
<html>
	<head>
		<title>Musihub</title>
        <link rel="icon" type="image/png" href="logo.png">
	</head>
	<body>
        <?php
        require_once "cabecera.php";
        ?>
		<br />
		<div class="container">
			<br />
			<br />
			<br />
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
            $limite = 12; // Limite
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

                        <br><br>
                        <?php
                        echo "<a style='margin-right:5px;' class='btn btn-principal btn-success' href='catalogo/carrito.php?id=" . encode($instrumento->getid()) . "' title='add' data-toggle='tooltip'>Añadir<span class='glyphicon glyphicon-shopping-cart'></span></a>";
                        echo "<a style='margin-left:5px;' class='btn btn-principal btn-info' href='catalogo/read_catalogo.php?id=" . encode($instrumento->getid()) . "' title='info' data-toggle='tooltip'>Detalles<span class='glyphicon glyphicon-list-alt'></span></a>";
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
        <?php require_once "footer.html";?>
	</body>
</html>
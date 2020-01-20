<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/musihub/dirs.php";
require_once CONTROLLER_PATH . "ControladorInstrumento.php";
require_once CONTROLLER_PATH . "Paginador.php";
require_once UTILITY_PATH . "funciones.php";
require_once "../../cabecera.php"; 
?>
<h2>Ficha de Instrumentos</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="no_imprimir">
    <div>
        <label for="instrumento">Buscar instrumento </label>
        <input type="text" id="buscar" name="instrumento" placeholder="Inserte Nombre o Referencia">
    </div>
    <button type="submit"> Buscar</button>

    <a href="javascript:window.print()"> IMPRIMIR</a>
    <a href="../../utilidades/descargar.php?opcion=TXT" target="_blank"> TXT</a>
    <a href="../../utilidades/descargar.php?opcion=PDF" target="_blank"> PDF</a>
    <a href="../../utilidades/descargar.php?opcion=XML" target="_blank"> XML</a>
    <a href="../../utilidades/descargar.php?opcion=JSON" target="_blank"> JSON</a>
    <a href="../vistas_instrumentos/create.php"> Añadir Instrumento</a>

</form>
</div>
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
$limite = 5; // Limite
$paginador  = new Paginador($consulta, $parametros, $limite);
$resultados = $paginador->getDatos($pagina);

if (count($resultados->datos) > 0) {
    echo "<table class='table table-bordered table-striped'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Nombre</th>";
    echo "<th>Referencia</th>";
    echo "<th>distribuidor</th>";
    echo "<th>tipo</th>";
    echo "<th>precio</th>";
    echo "<th>descuento</th>";
    echo "<th>stockinicial</th>";
    echo "<th>Imagen</th>";
    echo "<th>Accion</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($resultados->datos as $a) {

        $instrumento = new instrumento($a->id, $a->nombre, $a->referencia, $a->distribuidor, $a->tipo, $a->precio, $a->descuento, $a->stockinicial, $a->imagen);
        echo "<tr>";
        echo "<td>" . $instrumento->getnombre() . "</td>";
        echo "<td>" . $instrumento->getreferencia() . "</td>";
        echo "<td>" . $instrumento->getdistribuidor() . "</td>";
        echo "<td>" . $instrumento->gettipo() . "</td>";
        echo "<td>" . $instrumento->getprecio() . "</td>";
        echo "<td>" . $instrumento->getdescuento() . "</td>";
        echo "<td>" . $instrumento->getstockinicial() . "</td>";
        echo "<td><img src='../../imagenes/fotos/" . $instrumento->getimagen() . "' width='48px' height='48px'></td>";
        echo "<td>";
        echo "<a href='../vistas_instrumentos/read.php?id=" . encode($instrumento->getid()) . "' title='info' data-toggle='tooltip'>Info <span class='glyphicon glyphicon-eye-open'></span></a>";
        echo "<a href='../vistas_instrumentos/update.php?id=" . encode($instrumento->getid()) . "' title='Actualizar' data-toggle='tooltip'>Actualizar <span class='glyphicon glyphicon-eye-open'></span></a>";
        echo "<a href='../vistas_instrumentos/delete.php?id=" . encode($instrumento->getid()) . "' title='Borrar' data-toggle='tooltip'>Borrar <span class='glyphicon glyphicon-eye-open'></span></a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "<ul class='pager' id='no_imprimir'>";
    echo $paginador->crearLinks($enlaces);
    echo "</ul>";
} else {
    echo "<p class='lead'><em>No se ha encontrado datos de Instrumentos.</em></p>";
}
require_once VIEW_PATH . "../footer.html";
?>

<div id="no_imprimir">

    <?/*php

    if (isset($_COOKIE['CONTADOR'])) {
        echo $contador;
        echo $acceso;
    } else {
        echo "Es tu primera visita hoy";
    }
    */?>
</div>
<br><br><br>
</body>
</html>
<style>
body {
    font-family: Arial, Helvetica, sans-serif;}

    table {     
    font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
    font-size: 12px;    
    margin:1.5%;     
    width: 97%; 
    border-collapse: collapse; 
    border-bottom: 4px solid #aabcfe;
}
    

th {     
    font-size: 13px;     
    font-weight: normal;     
    padding: 8px;     
    background: #b9c9fe;
    border-top: 4px solid #aabcfe;    
    border-bottom: 1px solid #fff; 
    color: #039; }
.centrado{
    text-align: center;
}
td {    
    padding: 8px;     
    background: #e8edff;     
    border-bottom: 1px solid #d0dafd;
    color: #669;    
    border-top: 1px solid transparent; }

tr:hover td { 
    background: #d0dafd; 
    color: #339; }

a:hover{ 
    background: #d0dafd; 
    color: black; }
</style>
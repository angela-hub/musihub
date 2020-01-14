<div class="container-fluid">
<title>Listado de Usuarios</title>
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Lista de Usuarios</h2>
                </div>
                <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="no_imprimir">
                    <div class="form-group mx-sm-5 mb-2">
                        <label for="usuario" class="sr-only">Usuario</label>
                        <input type="text" class="form-control" id="buscar" name="usuario" placeholder="email">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2"> <span class="glyphicon glyphicon-search"></span>  Buscar</button>
                    <!-- Aquí va el nuevo botón para dar de alta, podría ir al final -->
                    <!--<a href="javascript:window.print()" class="btn pull-right"> <span class="glyphicon glyphicon-print"></span> IMPRIMIR</a> -->
                    <a href="../../utilidades/descargar.php?opcion=TXTUsu" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  TXT</a>
                    <a href="../../utilidades/descargar.php?opcion=PDFUsu" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  PDF</a>
                    <a href="../../utilidades/descargar.php?opcion=XMLUsu" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  XML</a>
                    <a href="../../utilidades/descargar.php?opcion=JSONUsu" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  JSON</a>
                    <a href="create_usu.php" class="btn btn-success pull-right"><span class="glyphicon glyphicon-user"></span>  Añadir Usuario</a>
                    
                </form>
            </div>

<?php
require_once $_SERVER['DOCUMENT_ROOT']."/musihub/dirs.php";
require_once CONTROLLER_PATH."ControladorUsuario.php";
require_once CONTROLLER_PATH. "Paginador.php";
require_once UTILITY_PATH. "funciones.php";

if (!isset($_POST["usuario"])){
    $email="";
}else {
    $email= filtrado($_POST["usuario"]);
}

$controlador= ControladorUsuario::getControlador();
$pagina = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
$enlaces = ( isset($_GET['enlaces']) ) ? $_GET['enlaces'] : 10;
$consulta="SELECT * FROM usuarios WHERE email LIKE :email";
$parametros=array(':email'=>"%". $email. "%");

$limite=5;
$paginador= new Paginador($consulta,$parametros,$limite);
$resultados=$paginador->getDatos($pagina);

if(count($resultados->datos)>0){
    echo "<table border='1' class='table table-bordered table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Nombre</th>";
        echo "<th>Apellidos</th>";
        echo "<th>Email</th>";
        echo "<th>Contraseña</th>";
        echo "<th>Administrador</th>";
        echo "<th>Telefono</th>";
        echo "<th>Fecha de Alta</th>";
        echo "<th>Foto</th>";
        echo "<th>Acción</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
    foreach($resultados->datos as $c){
        $usuario= new usuario($c->id, $c->nombre,$c->apellidos,$c->email,$c->password,$c->administrador,$c->telefono,$c->fecha_alta,$c->foto);

        echo "<tr>";
                    echo "<td>" . $usuario->getnombre() . "</td>";
                    echo "<td>" . $usuario->getapellidos() . "</td>";
                    echo "<td>" . $usuario->getemail() . "</td>";
                    echo "<td>" . str_repeat("*",strlen($usuario->getpassword()))  . "</td>";
                    echo "<td>" . $usuario->getadministrador() . "</td>";
                    echo "<td>" . $usuario->gettelefono() . "</td>";
                    echo "<td>" . $usuario->getfecha_alta() . "</td>";
                    echo "<td><img src='../../imagenes/fotos/".$usuario->getfoto()."' width='48px' height='48px'></td>";
                    echo "<td>";
                    echo "<a href='leer_usu.php?id=" . encode($usuario->getid()) . "' title='Ver usuario' data-toggle='tooltip'>Ver Usuario</span></a>" . "<br>";
                    //echo "<a href='accion/update.php?id=" . codificar($usuario->getid()) . "' title='Actualizar aspirante' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                    echo "<a href='borrar_usu.php?id=" . encode($usuario->getid()) . "' title='Borrar usuario' data-toggle='tooltip'>Borrar Usuario<span class='glyphicon glyphicon-trash'></span></a>";
                    echo "</td>";
                    echo "</tr>";
    }
            echo "</tbody>";
            echo "</table>";
            echo "<ul class='pager' id='no_imprimir'>"; //  <ul class="pagination">
            echo $paginador->crearLinks($enlaces);
            echo "</ul>";
        } else {
            // Si no hay nada seleccionado
            echo "<p class='lead'><em>No se ha encontrado ningun Usuario.</em></p>";
        }
?>
<a href="../inicio.php">Inicio</a>
<?php
/*
        // Leemos la cookie
        if(isset($_COOKIE['CONTADOR'])){
            echo $contador;
            echo $acceso;
        }
        else{
            echo "Es tu primera visita hoy";
        }
        */
    ?>
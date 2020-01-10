<div class="container-fluid">
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
                    <a href="javascript:window.print()" class="btn pull-right"> <span class="glyphicon glyphicon-print"></span> IMPRIMIR</a>
                    <a href="funciones/descargar.php?opcion=TXT" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  TXT</a>
                    <a href="funciones/descargar.php?opcion=PDF" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  PDF</a>
                    <a href="funciones/descargar.php?opcion=XML" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  XML</a>
                    <a href="funciones/descargar.php?opcion=JSON" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  JSON</a>
                    <a href="accion/create.php" class="btn btn-success pull-right"><span class="glyphicon glyphicon-user"></span>  Añadir Usuario</a>
                    
                </form>
            </div>

<?php

require_once CONTROLLER_PATH. "ControladorUsuario.php";
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
    echo "<table class='table table-bordered table-striped'>";
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
                    echo "<td>" . $usuario->apellidos() . "</td>";
                    echo "<td>" . $usuario->email() . "</td>";
                    echo "<td>" . $usuario->password() . "</td>";
                    echo "<td>" . $usuario->administrador() . "</td>";
                    echo "<td>" . $usuario->telefono() . "</td>";
                    echo "<td>" . $usuario->fecha_alta() . "</td>";
                    echo "<td><img src='imagenes/fotos/".$usuario->getimagen()."' width='48px' height='48px'></td>";
                    echo "<td>";
                    echo "<a href='accion/read.php?id=" . codificar($usuario->getid()) . "' title='Ver aspirante' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                    echo "<a href='accion/update.php?id=" . codificar($usuario->getid()) . "' title='Actualizar aspirante' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                    echo "<a href='accion/borrar.php?id=" . codificar($usuario->getid()) . "' title='Borrar aspirante' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
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
<?php
        // Leemos la cookie
        if(isset($_COOKIE['CONTADOR'])){
            echo $contador;
            echo $acceso;
        }
        else{
            echo "Es tu primera visita hoy";
        }
        
    ?>
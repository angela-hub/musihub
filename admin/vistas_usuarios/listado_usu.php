<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Listado de Usuarios</title>
</head>
<body>
<?php
require_once "../../cabecera.php";
//Comprobamos que existe la sesion 
if(isset($_SESSION['USUARIO']['email'])){
    //Comprobamos si es administrador o no y si lo es puede continuar en el caso de que no lo sea lo llevara a una página de error
    if($_SESSION['administrador'] == "si"){
?>
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Lista de Usuarios</h2>
                </div>
                <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="no_imprimir">
                    <div class="form-group mx-sm-5 mb-2">
                        <label for="usuario" class="sr-only">Usuario</label>
                        <input type="text" class="form-control" id="buscar" name="usuario" placeholder="Email">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2"> <span class="glyphicon glyphicon-search"></span>  Buscar</button>
                    <!-- Aquí va el nuevo botón para dar de alta, podría ir al final -->
                    <!--<a href="javascript:window.print()" class="btn pull-right"> <span class="glyphicon glyphicon-print"></span> IMPRIMIR</a> -->
                    <a href="../../utilidades/descargar.php?opcion=TXTUsu" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-save"></span>  TXT</a>
                    <a href="../../utilidades/descargar.php?opcion=PDFUsu" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-save"></span>  PDF</a>
                    <a href="../../utilidades/descargar.php?opcion=XMLUsu" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-save"></span>  XML</a>
                    <a href="../../utilidades/descargar.php?opcion=JSONUsu" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-save"></span>  JSON</a>
                    <a href="create_usu.php" class="btn btn-success pull-right"><span class="glyphicon glyphicon-user"></span>  Añadir Usuario</a>
                    <br><br>

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
//Ponemos el límite de usuarios por página de 5
$limite=5;
$paginador= new Paginador($consulta,$parametros,$limite);
$resultados=$paginador->getDatos($pagina);

if(count($resultados->datos)>0){
    echo "<table border='1'>";
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
                    echo "<td class='centrado'>" . str_repeat("*",strlen($usuario->getpassword()))  . "</td>";
                    echo "<td class='centrado'>" . $usuario->getadministrador() . "</td>";
                    echo "<td class='centrado'>" . $usuario->gettelefono() . "</td>";
                    echo "<td class='centrado'>" . $usuario->getfecha_alta() . "</td>";
                    echo "<td class='centrado'><img src='../../imagenes/fotos/".$usuario->getfoto()."' width='48px' height='48px'></td>";
                    echo "<td>";
                    echo "<a class='letra' href='leer_usu.php?id=" . encode($usuario->getid()) . "' title='Ver usuario'>Ver   <span class='glyphicon glyphicon-eye-open'></span></a>" . "<br>";
                    echo "<a class='letra' href='update_usu.php?id=" . encode($usuario->getid()) . "' title='Actualizar Usuario' >Editar   <span class='glyphicon glyphicon-edit'></span></a>" . "<br>";
                    echo "<a class='letra' href='borrar_usu.php?id=" . encode($usuario->getid()) . "' title='Borrar usuario' data-toggle='tooltip'>Borrar   <span class='glyphicon glyphicon-trash'></span></a>";
                    echo "</td>";
                    echo "</tr>";
    }
            echo "</tbody>";
            echo "</table>";
            echo $paginador->crearLinks($enlaces);
        } else {
            // Si no hay nada seleccionado
            echo "<p class='lead'><em>No se ha encontrado ningun Usuario.</em></p>";
        }
        require_once VIEW_PATH . "../footer.php";
?>
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
        // En caso de que no este logeado o no sea administrador les redireccionara a la pagina de error403
    }else{
        header("location:/musihub/error403.php");
    }
    }else{
        header("location:/musihub/error403.php");
    }
    ?>
    
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

.letra:hover{ 
    background: #d0dafd; 
    color: black; }
</style>

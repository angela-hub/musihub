<?php
//Directorios para trabajar
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once UTILITY_PATH . "funciones.php";
require_once CONTROLLER_PATH . "ControladorBD.php";
require_once CONTROLLER_PATH . "ControladorPago.php";

session_start();
if (isset($_SESSION['USUARIO']['email'])) {
    //$controlador = Controladorpago::getControlador();
    //$estado = $controlador->almacenarcarrrito($nombre,$distribuidor,$precio,$cantidad);
    if (isset($_POST['borrar'])) {
        $id=$_POST['borrar'];
        $_SESSION['carrito']['final'][$id]['cantidad']=$_SESSION['carrito']['final'][$id]['cantidad']-1;
        $_SESSION['cantidad']=$_SESSION['cantidad']-1;
        if($_SESSION['carrito']['final'][$id]['cantidad']<=0){
            unset($_SESSION['carrito']['final'][$id]);
        }
        header("location: /musihub/carrito/resumen.php");
    }
    if (isset($_POST['agregar'])) {
        $id=$_POST['agregar'];
        $_SESSION['carrito']['final'][$id]['cantidad']=$_SESSION['carrito']['final'][$id]['cantidad']+1;
        $_SESSION['cantidad']=$_SESSION['cantidad']+1;
        header("location: /musihub/carrito/resumen.php");
    }
    //Procesamo¡iento para vaciar todos los productos del carrito
    if (isset($_POST['vaciar'])) {
        unset($_SESSION['carrito']['final']);
        header("location: /musihub/carrito/resumen.php");
    }

    if(isset($_SESSION['carrito']['final']) && !empty($_SESSION['carrito']['final'])){
        $arreglo=$_SESSION['carrito']['final'];
        echo "<table><th></th><th>Instrumento</th><th>Distribuidor</th><th>Precio</th><th>Cantidad</th><th>Funcion</th>";
        foreach ($arreglo as $key => $fila){
            if($fila['cantidad']>=1){
            $foto = $fila['foto'];
            echo "<tr><td><img src='../imagenes/fotos/" . $foto . "' width='70px' height='70'></td>";
            echo "<td>" . $fila['nomProducto'] . "</td>";
            echo "<td>" . $fila['marca'] . "</td>";
            echo "<td>" . $fila['precio'] . "</td>";
            echo "<td>" . $fila['cantidad'] . "</td>";
            /*foreach($numero as $k => $v){
                if($k==$fila['idproducto']){
                    alerta($v);
                    echo "<td>" . $v . "</td>";
                    //alerta($v);
                }
            }*/
            ?>
            <td><form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                                <button class="btn btn-danger" type="submit" value="<?php print_r($fila['idproducto']); ?>" name="borrar" title='-1'>
                                    <span class='glyphicon glyphicon-trash'></span> -1</span>
                                </button>
                                </form>
            <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                            <button class="btn btn-danger" type="submit" value="<?php print_r($fila['idproducto']); ?>" name="agregar" title='+1'>
                                <span class='glyphicon glyphicon-trash'></span> +1</span>
                            </button>
                        </form></td>
                        <?php                  
        }
    }
        //echo "<td>" . $fila['idproducto'] . "</td>";
        echo "<tr>";
        echo "</table>";

    
}
    else{
        echo "No hay productos en el carrito";
    }
}
?>
<br><br>
<!--Link para el estilo de los botones-->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<!--Boton para volver al catalogo-->
<a href="/musihub/index.php" class="btn btn-warning" >Seguir comprando</a><br><br>
<!--Boton para continuar el proceso de compra-->
<a href="/musihub/carrito/fincarrito.php" class="btn btn-success" >Procesar compra</a><br><br>

<!--Boton para vaciar carrito-->
<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
    <button onclick="return confirm('¿Desea eliminar todos los productos del carrito?')" class="btn btn-danger" type="submit" 
            value="<?php print_r($fila['idproducto']); ?>" name="vaciar">
        <span>Vaciar carrito</span>
    </button>
</form>

<!-------------------------------------------------Estilo para la tabla--------------------------------------------------->

<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    table {
        font-family: "Comic Sans MS", "Lucida Grande", Sans-Serif;
        font-size: 18;
        margin: 1.5%;
        width: 97%;
        border-collapse: collapse;
        border-bottom: 4px solid #2F4F4F;
    }


    th {
        font-size: 25px;
        font-weight: normal;
        padding: 8px;
        background: #556B2F;
        border-top: 4px solid #2F4F4F;
        border-bottom: 4px solid #2F4F4F;
        color: #FFFAFA;
    }

    .centrado {
        text-align: center;
    }

    td {
        text-align: center;
        padding: 8px;
        background: #F0FFF0;
        color: #006400;
        border-top: 1px solid transparent;
    }

    tr:hover td {
        background: #8FBC8F;
        color: white;
    
</style>
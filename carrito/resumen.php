<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Carrito</title>
    <link rel="icon" type="image/png" href="logo.png">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <style>
    table {
        font-size: 150%;
            width: 95%;
        }
    h1 {
        font-size: 300px;
        text-align: center;
    }

    </style>
</head>

<?php
//Directorios para trabajar
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once UTILITY_PATH . "funciones.php";
require_once CONTROLLER_PATH . "ControladorBD.php";
require_once CONTROLLER_PATH . "ControladorPago.php";
require_once CONTROLLER_PATH . "ControladorInstrumento.php";

session_start();
if (!isset($_SESSION['USUARIO']['email'])){
    header("location:/musihub/login.php");
}
$_SESSION['pago']=[];
if (isset($_SESSION['USUARIO']['email'])) {
    //$controlador = Controladorpago::getControlador();
    //$estado = $controlador->almacenarcarrrito($nombre,$distribuidor,$precio,$cantidad);
    if (isset($_POST['borrar'])) {
        $id=$_POST['borrar'];
        $_SESSION['carrito']['final'][$id]['cantidad']=$_SESSION['carrito']['final'][$id]['cantidad']-1;
        $_SESSION['cantidad']=$_SESSION['cantidad']-1;
        if($_SESSION['carrito']['final'][$id]['cantidad']<=0){
            unset($_SESSION['carrito']['final'][$id]);
            unset($_SESSION['total'][$id]);
        }
        $precio=$_SESSION['carrito']['final'][$id]['precio'];
        if(isset($_SESSION['total'][$id])){
            $_SESSION['total'][$id]=$_SESSION['total'][$id]-$precio;
        }
        header("location: /musihub/carrito/resumen.php");
    }
    if (isset($_POST['agregar'])) {
        $id=$_POST['agregar'];
        $controlador = ControladorInstrumento::getControlador();
        $instrumento = $controlador->buscarinstrumentoid($id);
        $stock=$instrumento->getstockinicial();
        if($stock>$_SESSION['carrito']['final'][$id]['cantidad']){
            $_SESSION['carrito']['final'][$id]['cantidad']=$_SESSION['carrito']['final'][$id]['cantidad']+1;
            $_SESSION['cantidad']=$_SESSION['cantidad']+1;
            $precio=$_SESSION['carrito']['final'][$id]['precio'];
            if(!isset($_SESSION['total'][$id])|| empty($_SESSION['total'][$id])){
                $_SESSION['total'][$id]=$precio;
            }else{
                $_SESSION['total'][$id]=$_SESSION['total'][$id]+$precio;
            }
        }else{
            alerta("No hay mas stock de este articulo");
        }
        redir("/musihub/carrito/resumen.php");
    }
    if (isset($_POST['borr_item'])) {
        $id=$_POST['borr_item'];
        $_SESSION['cantidad']=$_SESSION['cantidad']-$_SESSION['carrito']['final'][$id]['cantidad'];
        unset($_SESSION['carrito']['final'][$id]);
        unset($_SESSION['total'][$id]);
    }
    //Procesamo¡iento para vaciar todos los productos del carrito
    if (isset($_POST['vaciar'])) {
        unset($_SESSION['carrito']['final']);
        header("location: /musihub/carrito/resumen.php");
        unset($_SESSION['cantidad']);
        unset($_SESSION['total']);
    }
    ?>
    <h1>Mi Carrito</h1>
    <div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
            <table class="table table-hover">

    <?php
    if(isset($_SESSION['carrito']['final']) && !empty($_SESSION['carrito']['final'])){
        $arreglo=$_SESSION['carrito']['final'];
        echo "<thead>";
            echo"<tr>";
            echo "<th></th>";
            echo"<th>Instrumento</th>";
            echo"<th>Distribuidor</th>";
            echo"<th>Precio</th>";
            echo"<th >Cantidad</th>";
            echo"<th>Funcion </th>";
            echo"</tr>";
        echo" </thead>";
        echo "<tbody>";
        foreach ($arreglo as $key => $fila){
            if($fila['cantidad']>=1){
            $foto = $fila['foto'];
            echo "<tr><td><img src='../imagenes/fotos/" . $foto . "' width='70px' height='70'></td>";
            echo "<td>" . $fila['nomProducto'] . "</td>";
            echo "<td>" . $fila['marca'] . "</td>";
            echo "<td>" . $fila['precio'] . " ". "€" ."</td>";
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
                                <button class="btn btn-warning" type="submit" value="<?php print_r($fila['idproducto']); ?>" name="borrar" title='-1'>
                                    <span class='glyphicon glyphicon-arrow-down'></span></span>
                                </button>
                                </form>
            <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                            <button class="btn btn-success" type="submit" value="<?php print_r($fila['idproducto']); ?>" name="agregar" title='+1'>
                                <span class='glyphicon glyphicon-arrow-up'></span></span>
                            </button>
                        </form>
            <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                            <button class="btn btn-danger" type="submit" value="<?php print_r($fila['idproducto']); ?>" name="borr_item" >
                                <span class='glyphicon glyphicon-trash'></span></span>
                            </button>
                        </form></td>
                        <?php                  
        }
    }
        //echo "<td>" . $fila['idproducto'] . "</td>";
        $final=array_sum($_SESSION['total']);
        $_SESSION['precio']=$final;
        echo "<tr>";
        //Calculo del precio sin iva
        $sub=$final/1.21;
        //calculo del precio con iva
        $iva=$final-($final/1.21);

        //Mostramos la tabla con los precios calculados y redondeados a dos decimales
        echo "<td></td><td></td><td></td><td></td><td>". "<strong>" . "Subtotal" . "</strong>" ."  ". round($sub,2) . " ". "€". "</td>";
        echo "<tr>";
        echo "<td></td><td></td><td></td><td></td><td>". "<strong>". "IVA". "</strong>" . "  ". round($iva,2). " ". "€". "</td>";
        echo "<tr>";
        echo "<td></td><td></td><td></td><td></td><td><h2>". "<strong>". "Total". "</strong>" ."  ". $final. " ". "€". "</h2></td>";
        echo "</tr>";
        echo "</table>";
        
    
}
    else{
        echo "<h3>"."No hay productos en el carrito"."</h3>";
    }
}
?>
<br><br>
<!--Link para el estilo de los botones-->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<table>
<tr>
<!--Boton para volver al catalogo-->
<td><a href="/musihub/index.php" class="btn btn-warning" >Seguir comprando</a></td>

<!--Boton para vaciar carrito-->
<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
<td><button onclick="return confirm('¿Desea eliminar todos los productos del carrito?')" class="btn btn-danger" type="submit" 
            value="<?php print_r($fila['idproducto']); ?>" name="vaciar">
        <span>Vaciar carrito</span></td>
    </button>
</form>

<!--Boton para continuar el proceso de compra-->
<td><a href="/musihub/carrito/fincarrito.php" class="btn btn-success" >Procesar compra</a></td>
</tr>
</table>
<br><br><br><br>
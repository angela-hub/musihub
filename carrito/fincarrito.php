<?php

// Lo que necesitamos
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once VIEW_PATH . "../cabecera.php";

// Solo entramos si somos el usuario y hay items
if ((!isset($_SESSION['nombre'])) || $_SESSION['cantidad'] == 0) {
    header("location: /musihub/error.php");
    exit();
}
/*
$total = $_SESSION['total'];

// Procesamos el usuario de la sesion
$id = $_SESSION['id'];
$nombre = $_SESSION['nombre'];
$email = $_SESSION['email'];

// Procesamos la venta
if (isset($_POST['procesar_compra'])) {
    // Generamos el id de la compra
    $idVenta = date('ymd-his');
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $nombreTarjeta = $_POST['tTitular'];
    $numeroTarjeta = $_POST['cardNumber'];
// Metemos dentro de la variable venta la nueva venta que se procesara y se insertara en la base de datos
    $venta = new Venta(
        $idVenta,
        "",
        $total,
        round(($total / 1.21), 2),
        round(($total - ($total / 1.21)), 2),
        $nombre,
        $email,
        $direccion,
        $nombreTarjeta,
        $numeroTarjeta
    );

    $cv = ControladorVenta::getControlador();
    // Se inserta la venta creada anteriormente
    if ($cv->insertarVenta($venta)) {
        $cs = ControladorAcceso::getControlador();
        header("location:/musihub/carrito/facturacarrito.php?venta=" . encode($idVenta));
        //alerta("Venta procesada", "../vistas/facturacarrito.php?venta=" . encode($idVenta));
        exit();
    } else {
        alerta("Existe un error al procesar la venta");
    }
}
*/
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Proc. Pedido</title>
    <link rel="icon" type="image/png" href="logo.png">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <style type="text/css">
        .colorgraph {
            height: 5px;
            border-top: 0;
            background: #c4e17f;
            border-radius: 5px;
            background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
            background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
            background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
            background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
        }
    </style>
</head>
<?php
$nombre = $email = $telefono = $direccion = "";
$nombreErr = $emailErr = $telefonoErr = $direccionErr ="";

// Procesamos el nombre
$nombre = filtrado(($_POST["nombre"]));
if(empty($nombre)){
    $nombreErr = "Por favor introduzca un nombre válido con solo carávteres alfabéticos.";
} elseif(!preg_match("/([^\s][A-zÀ-ž\s]+$)/", $nombre)) {
    $nombreErr = "Por favor introduzca un nombre válido con solo carávteres alfabéticos.";
} else{
    $nombre= $nombre;
}

// Procesamos el email
$email = filtrado($_POST["email"]);
if(empty($email)){
    $emailErr = "Por favor introduzca email válido.";
} else{
    $email= $email;
}

// Procesamos el teléfono
$telefono= filtrado($_POST["telefono"]);
if(empty($telefono)){
    $telefonoErr="Por favor Introduzca un telefono válido";
}elseif(!filter_var($telefono, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/[0-9]{9}/")))){
    $telefonoErr="Por favor intruduzca un teléfono válida con el formato NNNNNNNNN";
}else{
    $telefono=$telefono;
}

// Procesamos la direccion
$direccion = filtrado(($_POST["direccion"]));
if(empty($direccion)){
    $direccionErr = "Por favor introduzca un nombre válido con solo carávteres alfabéticos.";
} elseif(!preg_match("/([^\s][A-zÀ-ž\s]+$)/", $direccion)) {
    $direccionErr = "Por favor introduzca un nombre válido con solo carávteres alfabéticos.";
} else{
    $direccion= $direccion;
}
?>

<div class="container">
<div class="row">
        <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <center><h2>Datos <small>Rellenalos para el envío</small></h2></center>
            <hr class="colorgraph">

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6" <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>">
                    <div class="form-group">
                        <input type="text" required name="nombre" class="form-control input-lg" placeholder="Nombre" tabindex="1" value="<?php echo $nombre; ?>">
                        <span class="help-block"><?php echo $nombreErr; ?></span>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-6" <?php echo (!empty($emailErr)) ? 'error: ' : ''; ?>">
                <input type="email" required name="email" class="form-control input-lg" placeholder="E-mail" tabindex="3" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $emailErr; ?></span>
            </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6" <?php echo (!empty($telefonoErr)) ? 'error: ' : ''; ?>">
                    <input type="tel" required name="telefono" class="form-control input-lg" placeholder="Telefono" tabindex="5" value="<?php echo $telefono; ?>" pattern="[0-9]{9}" title="Debes poner 9 números">
                    <span class="help-block"><?php echo $telefonoErr; ?></span>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-6" <?php echo (!empty($direccionErr)) ? 'error: ' : ''; ?>">
                    <div class="form-group">
                        <input type="text-area" required name="direccion" class="form-control input-lg" placeholder="Direccion" tabindex="1" value="<?php echo $direccion; ?>">
                        <span class="help-block"><?php echo $direccionErr; ?></span>
                    </div>
                </div>
            </div>
            <hr class="colorgraph">
            <div class="row">
                <div class="col-xs-12 col-md-6"><a href="resumen.php" class="btn btn-warning btn-block btn-lg">Atrás</a></div>
                <div class="col-xs-12 col-md-6"><a href="pago.php" class="btn btn-success btn-block btn-lg">Pago</a></div>
            </div>
        </form>
    </div>
</div>
</div>

<br><br>

    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel-heading">Resumen de su pedido</div>
                <div class="panel-body">
                    <?php

                    if(isset($_SESSION['carrito']['final']) && !empty($_SESSION['carrito']['final'])){
                        $arreglo=$_SESSION['carrito']['final'];
                        echo "<table><th></th><th>Instrumento</th><th>Distribuidor</th><th>Precio</th><th>Cantidad</th>";
                        foreach ($arreglo as $key => $fila){
                            if($fila['cantidad']>=1){
                            $foto = $fila['foto'];
                            echo "<tr><td><img src='../imagenes/fotos/" . $foto . "' width='70px' height='70'></td>";
                            echo "<td>" . $fila['nomProducto'] . "</td>";
                            echo "<td>" . $fila['marca'] . "</td>";
                            echo "<td>" . $fila['precio'] . "</td>";
                            echo "<td>" . $fila['cantidad'] . "</td>";
                            }
                        }
                    ?>
                    <?php
                        }
                        // Subtotales y totales
                        $final=array_sum($_SESSION['total']);
                        $_SESSION['precio']=$final;
                        echo "<tr>";
                        //Calculo del precio sin iva
                        $sub=$final/1.21;
                        //calculo del precio con iva
                        $iva=$final-($final/1.21);

                        //Mostramos la tabla con los precios calculados y redondeados a dos decimales
                        echo "<td>". "Subtotal" ."  ". round($sub,2) . " ". "€". "</td>";
                        echo "<tr>";
                        echo "<td>". "IVA" ."  ". round($iva,2). " ". "€". "</td>";
                        echo "<tr>";
                        echo "<td>". "Total" ."  ". $final. " ". "€". "</td>";
                        echo "</tr>";
                    ?>
        
            



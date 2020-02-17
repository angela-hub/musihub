<?php

// Lo que necesitamos
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once VIEW_PATH . "../cabecera.php";
/*
// Solo entramos si somos el usuario y hay items
if ((!isset($_SESSION['nombre'])) || $_SESSION['cantidad'] == 0) {
    header("location: /musihub/error.php");
    exit();
}
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

<br><br>
<div class="row cart-body">
    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" class="form-horizontal">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-push-6 col-sm-push-6">
            <div class="panel panel-default">
                <div class="panel-heading">Pedido
                    <div class="pull-right">
                        <small><a href='resumen.php'>Editar</a></small>
                    </div>
                </div>
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
                    ?>
                    <!-- Subtotales y totales -->

                    
                    <div class="form-group">
                        <div class="col-xs-12">
                            Subtotal:
                            <div class="pull-right"><span><?php echo round(($total / 1.21), 2); ?> €</span></div>
                        </div>
                        <div class="col-xs-12">
                            <small>I.V.A.: </small>
                            <div class="pull-right">
                                <span><?php echo round(($total - ($total / 1.21)), 2); ?> €</span></div>
                        </div>
                        <div class="col-xs-12">
                            <strong>TOTAL: </strong>
                            <div class="pull-right">
                                <span><strong><?php echo round(($total), 2); ?> €</strong></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-pull-6 col-sm-pull-6">
            <!-- Panel de envío -->
            <div class="panel panel-default">
            <img class="img-responsive pull-right" height="100px" width="100px" src="https://www.sendiroo.es/design/img/envios/baratos/enviarPesados1.jpg">
                <div class="panel-heading">Envío</div>           
                <div class="panel-body">
                    <!-- Nombre-->
                    <div class="form-group">
                        <div class="col-md-2">
                            <label for="name" class="col-md-3 control-label">Nombre:</label>
                        </div>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre y apellidos" required value="<?php echo $nombre; ?>" pattern="([^\s][A-zÀ-ž\s]+)" title="El nombre no puede contener números" minlength="3">
                        </div>
                    </div>
                    <!-- Email-->
                    <div class="form-group">
                        <div class="col-md-2">
                            <label for="name" class="col-md-3 control-label">Email:</label>
                        </div>
                        <div class="col-md-12">
                            <input type="email" class="form-control" name="email" placeholder="Email" required value="<?php echo $email; ?>">
                        </div>
                    </div>

                    <!-- Direccion -->
                    <div class="form-group">
                        <div class="col-md-2">
                            <label for="name" class="col-md-3 control-label">Dirección:</label>
                        </div>
                        <div class="col-md-12">
                            <textarea type="text" class="form-control" name="direccion" placeholder="Direccion" required></textarea>
                        </div>
                    </div>


                </div>
            </div>
    </form>
</div>
<center>
<a href='pago.php' class='btn btn-success' style="font-weight: bold">Continuar</a>
</center>
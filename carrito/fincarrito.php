<?php

// Lo que necesitamos
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once VIEW_PATH . "../cabecera.php";

// Solo entramos si somos el usuario y hay items
if ((!isset($_SESSION['nombre'])) || $_SESSION['uds'] == 0) {
    header("location: error.php");
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

?>

<br><br>
<div class="row cart-body">
    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" class="form-horizontal">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-push-6 col-sm-push-6">
            <div class="panel panel-default">
                <div class="panel-heading">Pedido
                    <div class="pull-right">
                        <small><a href='carrito.php'>Editar</a></small>
                    </div>
                </div>
                <div class="panel-body">
                    <?php

                    foreach ($_SESSION['carrito'] as $key => $value) {
                        if (($value[0] != null)) {
                            $id = $key;
                            $producto = $value[0];
                            $cantidad = $value[1];
                    ?>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-3">
                                    <!-- Imagen -->
                                    <img class="img-responsive" src='../imagenes/fotos/<?php echo $producto->getImagen(); ?>' alt='imagen' width='70'>
                                </div>
                                    <!-- Nombre, tipo y Precio -->
                                <div class="col-sm-6 col-xs-6">
                                    <div class="col-xs-12"><?php echo $producto->getnombre(); ?></div>
                                    <div class="col-xs-12"><?php echo $producto->gettipo(); ?></div>
                                    <div class="col-xs-12"><small>Precio:
                                            <span><?php echo $producto->getPrecio(); ?> €</span></small></div>
                                    <div class="col-xs-12"><small>Cantidad:
                                            <span><?php echo $cantidad; ?></span></small></div>
                                </div>
                                <div class="col-sm-3 col-xs-3 text-right">
                                    <h6><?php echo $producto->getPrecio() * $cantidad; ?> €</h6>
                                </div>
                            </div>
                            <div class="form-group">
                                <hr>
                            </div>
                    <?php
                        }
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
            <!-- Formulario de pago con tarjetas de credito -->
            <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
            <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

            <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>

            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-8">
                        <div class="panel panel-default credit-card-box">
                            <div class="panel-heading display-table">
                                <div class="row display-tr">
                                    <h3 class="panel-title display-td">Pago Electronico</h3>
                                    <div class="display-td">
                                        <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form role="form" id="payment-form" method="POST" action="javascript:void(0);">
                                    <div class="form-group">
                                            <label for="name">TITULAR</label>
                                            <input type="text" class="form-control" name="tTitular" placeholder="Titular de la tarjeta" required pattern="([^\s][A-zÀ-ž\s]+)" title="El nombre no puede contener números" minlength="3">
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label for="cardNumber">NUMERO TARJETA</label>
                                                <div class="input-group">
                                                    <input type="tel" class="form-control" name="cardNumber" placeholder="Número valido de tarjeta" autocomplete="cc-number" required autofocus />
                                                    <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="cardCVC">CODIGO CV</label>
                                        <input type="tel" class="form-control" name="cardCVC" placeholder="CVC" autocomplete="cc-csc" required />
                                    </div>
                                    <div class="form-group">
                                    <div>
                                        <label for="name">Caducidad:</label>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <select name="tMes" class="form-control" required>
                                            <option value="01">Enero</option>
                                            <option value="02">Febrero</option>
                                            <option value="03">Marzo</option>
                                            <option value="04">Abril</option>
                                            <option value="05">Mayo</option>
                                            <option value="06">Junio</option>
                                            <option value="07">Juilio</option>
                                            <option value="08">Agosto</option>
                                            <option value="09">Septiembre</option>
                                            <option value="10">Octubre</option>
                                            <option value="11">Noviembre</option>
                                            <option value="12">Diciembre</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <select name="tAño" class="form-control" required>
                                            <option value="2020">2020</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                        </select>
                                    </div>
                                </div>
                                    <div class="form-group">
                                        <div class="col-md-12 text-center text-center">
                                            <!-- Seguir comprando -->
                                            <a href='../index.php' class='btn btn-default'><span class='glyphicon glyphicon-shopping-cart'></span> Seguir comprando </a>
                                            <!-- Pagar -->
                                            <button class="btn btn-success" type="submit" name="procesar_compra" title='Pagar compra' onclick="return confirm('¿Seguro que desea pagar esta compra?')">
                                                <span class='glyphicon glyphicon-credit-card'></span> Pagar</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row" style="display:none;">
                                        <div class="col-xs-12">
                                            <p class="payment-errors"></p>
                                        </div>
                                    </div>
                                </form>
    </form>
</div>
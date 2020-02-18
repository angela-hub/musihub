<?php

// Lo que necesitamos
require_once $_SERVER['DOCUMENT_ROOT']."/musihub/dirs.php";
require_once CONTROLLER_PATH . "ControladorAcceso.php";
require_once UTILITY_PATH . "funciones.php";
require_once CONTROLLER_PATH . "ControladorVenta.php";
require_once VIEW_PATH . "../cabecera.php";

//$cs->destruirCookie();

// Solo entramos si somos el usuario y hay items
if ((!isset($_SESSION['USUARIO']['email']))) {
    header("location: /musihub/error.php");
    exit();
}
print_r($_SESSION['venta']);

/*$idVenta = decode($_GET['venta']);
$cv = ControladorVenta::getControlador();
$venta = $cv->buscarVentaID($idVenta);
$lineas = $cv->buscarLineasID($idVenta);
*/

?>
<!-- Distribucion de diseño y recogida de datos para la creacion de la factura al procesar el carrito -->

<main role="main">
    <div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<section class="page-header clearfix text-center">
                    <h3 class="pull-left">Factura</h3>
                    <h3 class="pull-right">Pedido nº: <?php echo $_SESSION['venta']['idventa']; ?></h3>
</section>
</div>

<hr>
<div class="row">
    <div class="col-xs-6">
        <address>
            <strong>Facturado a:</strong><br>
            <?php echo $_SESSION['nombre']; ?><br>
        </address>
    </div>
    <div class="col-xs-6 text-right">
        <address>
            <strong>Enviado a:</strong><br>
            <?php echo $_SESSION['venta']['nombre']; ?><br>
            <?php echo $_SESSION['venta']['email']; ?><br>
            <?php echo $_SESSION['venta']['direccion']; ?><br>
        </address>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <address>
            <strong>Método de pago:</strong><br>
            Tarjeta de crédito/debito: **** <?php echo $_SESSION['venta']['tarjetapago']; ?><br>
        </address>
    </div>
    <div class="col-xs-6 text-right">
        <address>
            <strong>Fecha de compra:</strong><br>
            <?php
                $fech = new DateTime($_SESSION['venta']['fecha']);
                echo $fech->format('d/m/Y'); 
            ?>
            <br><br>
        </address>
    </div>
</div>
</div>
</div>
    <div class="content content_content" style="width: 95%; margin: auto;">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Productos</strong></h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead>
                        <tr>
                            <td><strong>Item</strong></td>
                            <td class="text-center"><strong>Precio (PVP)</strong></td>
                            <td class="text-center"><strong>Cantidad</strong></td>
                            <td class="text-right"><strong>Total</strong></td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $arreglo=$_SESSION['carrito']['final'];
                        foreach ($arreglo as $key => $fila) {
                            echo "<tr>";
                            echo "<td>".$fila['nomProducto']." ".$fila['marca']."</td>";
                            echo "<td class='text-center'>".$fila['precio']." €</td>";
                            echo "<td class='text-center'>".$fila['cantidad']."</td>";
                            echo "<td class='text-right'>".($fila['precio']*$fila['cantidad'])." €</td>";
                            echo "</tr>";
                        }
                        $final=$_SESSION['precio'];
                        $sub=$final/1.21;
                        //calculo del precio con iva
                        $iva=$final-($final/1.21);
                        ?>

                        <tr>
                            <td class="thick-line"></td>
                            <td class="thick-line"></td>
                            <td class="thick-line text-center"><strong>Total sin IVA</strong></td>
                            <td class="thick-line text-right"><?php round($sub,2); ?> €</td>
                        </tr>
                        <tr>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class="no-line text-center"><strong>I.V.A</strong></td>
                            <td class="no-line text-right"><?php echo round($iva,2); ?> €</td>
                        </tr>
                        <tr>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class="no-line text-center"><strong>TOTAL</strong></td>
                            <td class="no-line text-right"><strong><?php echo $final; ?> €</strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    </div>
    <div class="row no-print nover">
        <div class='text-center'>
            <a href="javascript:window.print()" class='btn btn-info'><span class='glyphicon glyphicon-print'></span> Imprimir </a>
            <a href="../index.php" class='btn btn-success'><span class='glyphicon glyphicon-ok'></span> Finalizar </a>
            <?php
            echo "<a href='/musihub/utilidades/descargar.php?opcion=FACTURA&id=".encode($_SESSION['venta']['idventa']). " ' target='_blank' class='btn btn-primary'><span class='glyphicon glyphicon-download'></span>  PDF</a>";
            ?>

        </div>
    </div>

</main>
<br><br>

<?php
//Llamamos al footer
require_once VIEW_PATH . "../footer.php";
?>
<?php

// Lo que necesitamos
require_once $_SERVER['DOCUMENT_ROOT']."/musihub/dirs.php";
require_once CONTROLLER_PATH . "ControladorAcceso.php";
require_once UTILITY_PATH . "funciones.php";
//require_once VIEW_PATH . "../cabecera.php";
session_start();
// Solo entramos si somos el usuario y hay items
if ((!isset($_SESSION['USUARIO']['email']) || $_SESSION['factura'] <> "si")) {
    header("location: /musihub/error.php");
    exit();
}
//Vaciamos las sesiones que utilizamos en la compra una vez que se ha terminado todo el tramite del carrito
if (isset($_POST['finalizar'])) {
alerta("Gracias por confiar y realizar su compra con nosotros");
$_SESSION['carrito']=[];
$_SESSION['cantidad']=[];
$_SESSION['precio']=[];
$_SESSION['factura']=[];
redir("/musihub/index.php");
}
?>
<!------------------------------- Pagina de la factura final -------------------------------------------->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Factura</title>
    <link rel="stylesheet" href="../css/estilo.css" media="all" />
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  </head>
  <body class="centro">
    <header class="clearfix">
      <div id="logo">
        <img src="../logo.png">
      </div>
      <div id="company">
        <h2 class="name">Musihub</h2>
        <div>Calle Paloma nº11 s/n</div>
        <div>+34 666 55 55 55</div>
        <div><a href="mailto:musihub@tiendainstrumentos.com">musihub@tiendainstrumentos.com</a></div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
                    <h3 class="pull-right">Numero de pedido: <?php echo $_SESSION['venta']['idventa']; ?></h3>
        </div>
        <div id="invoice">
        <strong>Facturado a:</strong><br>
            <?php echo $_SESSION['nombre']; ?><br> 
            <strong>Enviado a:</strong><br>
            <?php echo $_SESSION['venta']['nombre']; ?><br>
            <?php echo $_SESSION['venta']['email']; ?><br>
            <?php echo $_SESSION['venta']['direccion']; ?><br>
            <strong>Método de pago:</strong><br>
            Tarjeta de crédito/debito: **** <?php echo $_SESSION['venta']['tarjetapago']; ?><br>
            <strong>Fecha de compra:</strong><br>
            <?php
                $fech = new DateTime($_SESSION['venta']['fecha']);
                echo $fech->format('d/m/Y'); 
            ?>
        </div>
      </div>
      <hr>


      <table border="0" cellspacing="0" cellpadding="0">
    <h3><strong>Productos</strong></h3>
        <thead>
            <tr>
                <th class="no">Instrumento</th>
                <th class="no">Distribuidor</th>
                <th class="no">Precio</th>
                <th class="no">Cantidad</th>
                <th class="no">TOTAL</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $arreglo=$_SESSION['carrito']['final'];
        foreach ($arreglo as $key => $fila) {
            echo "<tr>";
            echo "<td class='qty'>".$fila['nomProducto'];
            echo "<td class='qty'>".$fila['marca']."</td>";
            echo "<td class='qty'>".$fila['precio']." €</td>";
            echo "<td class='qty'>".$fila['cantidad']."</td>";
            echo "<td class='qty'>".($fila['precio']*$fila['cantidad'])." €</td>";
            echo "</tr>";
        }
        //PRECIOS obtenidos de la sesion de precio
        $final=$_SESSION['precio'];
        //el Subtotal lo obtenemos dividiendo el precio entre 1.21
        $sub=$final/1.21;
        //el calculo del iva es restando al precio final entre 1.21
        $iva=$final-($final/1.21);
        ?>

        <tr>
            <td class="thick-line"></td>
            <td class="thick-line"></td>
            <td class="thick-line"></td>
            <td class="unit"><strong>Total sin IVA</strong></td>
            <td class="unit"><?php echo round($sub,2); ?> €</td>
        </tr>
        <tr>
            <td class="no-line"></td>
            <td class="no-line"></td>
            <td class="no-line"></td>
            <td class="unit"><strong>I.V.A</strong></td>
            <td class="unit"><?php echo round($iva,2); ?> €</td>
        </tr>
        <tr>
            <td class="no-line"></td>
            <td class="no-line"></td>
            <td class="no-line"></td>
            <td class="unit"><strong>TOTAL</strong></td>
            <td class="unit"><strong><?php echo $final; ?> €</strong></td>
        </tr>
        </tbody>
        </table>
    <div class="row no-print nover">
        <div class='text-center'>
        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
            <button class="btn btn-success" type="submit" name="finalizar" >
                                <span class='glyphicon glyphicon-ok'></span> Finalizar</span></button>
                                
            <?php
            echo "<a href='/musihub/utilidades/descargar.php?opcion=FACTURA&id=".encode($_SESSION['venta']['idventa']). " ' target='_blank' class='btn btn-primary'><span class='glyphicon glyphicon-download'></span>  PDF</a>";
            echo "</form>";
            ?>

        </div>
    </div>
</main>

<footer>
    La tienda Musihub le agradece su compra, Hasta la proxima.
</footer>
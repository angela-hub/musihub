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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        table {
            width: 95%;
        }
        th, td {
            width: 25%;
            text-align: left;
            vertical-align: top;
        }
    </style>
</head>

<?php
$nombre = $email = $telefono = $direccion = "";
$nombreErr = $emailErr = $telefonoErr = $direccionErr ="";

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["aceptar"]){

    // Procesamos el nombre
    $nombre=$_POST["nombre"];
    if(isset($_POST["nombre"]) && !preg_match("/^([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){3,18}\s+([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){3,36}$/iu", $nombre)) { 
        $nombreErr = "Introduzca un nombre y apellidos";
      }

    // Procesamos el email
    $email = filtrado($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Por favor introduzca email válido.";
    }

    // Procesamos el teléfono
    $telefono= filtrado($_POST["telefono"]);
    if(empty($telefono)){
        $telefonoErr="Por favor Introduzca un numero de telefono";
    }elseif(!filter_var($telefono, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/[0-9]{9}/")))){
        $telefonoErr="Por favor intruduzca un teléfono válido";
    }

    // Procesamos la direccion
    $direccion = filtrado(($_POST["direccion"]));
    if(empty($direccion)){
        $direccionErr = "Por favor introduzca una direccion";
    }elseif(!preg_match("/^([A-Za-zÑñ]+[áéíóú]?[A-Za-z]){1,18}\s?([A-Za-zÑñ]+[áéíóú]?[A-Za-z]){0,10}\s?([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){2,10}\s+[1-9]{0,3}$/iu", $direccion)){
    $Errdireccion= "Introduce una direccion valida , valores validos : calle numero";
    }else{
    $direccion = $direccion;
    }
    
    
    if (
        empty($nombreErr) && empty($emailErr) && empty($telefonoErr) && empty($direccionErr)
    ) {
        $_SESSION['venta']=[];
        $_SESSION['venta']['nombre']=$nombre;
        $_SESSION['venta']['email']=$email;
        $_SESSION['venta']['telefono']=$telefono;
        $_SESSION['venta']['direccion']=$direccion;
        $_SESSION['pago']="si";
        header('location: pago.php');
    }
}
?>

<div class="container">
    <div class="row">
        <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <center><h2>Datos <small>Rellenalos para el envío</small></h2></center>
            <hr class="colorgraph">

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6" <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>>
                    <div class="form-group">
                        <input type="text" required name="nombre" pattern="([^\s][A-zÀ-ž\s]+$)" class="form-control input-lg" placeholder="Nombre y primer apellido" tabindex="1">
                        <span class="help-block"><?php echo $nombreErr; ?></span>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-6" <?php echo (!empty($emailErr)) ? 'error: ' : ''; ?>>
                <input type="email" required name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" class="form-control input-lg" 
                placeholder="E-mail" tabindex="3" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $emailErr; ?></span>
            </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6" <?php echo (!empty($telefonoErr)) ? 'error: ' : ''; ?>>
                    <input type="tel" required name="telefono" class="form-control input-lg" placeholder="Telefono" tabindex="5" pattern="[0-9]{9}" 
                    title="Debes poner 9 números">
                    <span class="help-block"><?php echo $telefonoErr; ?></span>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-6" <?php echo (!empty($direccionErr)) ? 'error: ' : ''; ?>>
                    <div class="form-group">
                        <input type="text-area" required name="direccion"  
                        class="form-control input-lg" placeholder="calle numero" 
                        pattern='^([A-Za-zÑñ]+[áéíóú]?[A-Za-z]){1,18}\s?([A-Za-zÑñ]+[áéíóú]?[A-Za-z]){0,10}\s?([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){2,10}\s+[1-9]{0,3}$' tabindex="1">
                        <span class="help-block"><?php echo $direccionErr; ?></span>
                    </div>
                </div>
            </div>
            <hr class="colorgraph">
            <div class="row">
                <div class="col-xs-12 col-md-6"><a href="resumen.php" class="btn btn-warning btn-block btn-lg">Atrás</a></div>
                <div class="col-xs-12 col-md-6"><button type="submit" name="aceptar" class="btn btn-success btn-block btn-lg" value="aceptar" class="btn btn-success">Aceptar</button></div>
            </div>
        </form>
    </div>
</div>

<br><br>

<div class="panel panel-success">
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
            }
            ?>

            <?php
            // Subtotales y totales
            $final=array_sum($_SESSION['total']);
            $_SESSION['precio']=$final;
            echo "<tr>";
            //Calculo del precio sin iva
            $sub=$final/1.21;
            //calculo del precio con iva
            $iva=$final-($final/1.21);

            //Mostramos la tabla con los precios calculados y redondeados a dos decimales
            echo "<td></td><td></td><td></td><td>". "<strong>"."Subtotal". "</strong>"."  ". round($sub,2) . " ". "€". "</td>";
            echo "<tr>";
            echo "<td></td><td></td><td></td><td>". "<strong>". "IVA" . "</strong>"."  ". round($iva,2). " ". "€". "</td>";
            echo "<tr>";
            echo "<td></td><td></td><td></td><td>". "<strong>"."Total" . "</strong>"."  ". $final. " ". "€". "</td>";
            echo "</tr>";
            echo "</table>";
        ?>
      </div>
</div>

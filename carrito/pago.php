<?php
// Directorios a usar 
require_once $_SERVER['DOCUMENT_ROOT']."/musihub/dirs.php";
require_once UTILITY_PATH . "funciones.php";
require_once CONTROLLER_PATH . "ControladorBD.php";
require_once CONTROLLER_PATH . "ControladorInstrumento.php";
require_once CONTROLLER_PATH . "ControladorPago.php";
require_once MODEL_PATH . "pago.php";
//Declaracion de variables
$titular = $tarjeta = $cvv = $num1 = $num2 =$num3 = $num4 = "";
$fechaErr = $titularErr = $tarjetarErr = $cvvErr =""; 

//Para poder hacer el pago tiene que estar la session iniciada
session_start();

//seguro para que la sesion este iniciada, tenga una cantidad de productos añadidos al carro 
if ((!isset($_SESSION['nombre'])) || $_SESSION['cantidad'] == 0 || $_SESSION["pago"] <> "si") {
  header("location: /musihub/error.php");
  exit();
}
//procesamos el formulario cuando se envia al darle al boton pagar
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["pagar"]){

    //Procesamos la fecha para que cuando se procese el pago no sea una fecha inferior a la actual.
    //ya que se puede estar pagando con una tarjeta caducada
    $fecha = date("d-m-Y", strtotime(filtrado($_POST["fecha"])));
    $hoy =date("d-m-Y");
    $titular=$_POST["titular"];
        if(strftime($fecha)<=strftime($hoy)){
            $fechaErr = "La fecha no puede ser inferior o igual a la fecha actual";
        }else{
            $fecha = date("d/m/Y", strtotime(filtrado($_POST["fecha"])));
        }
    //procesamos el titular para que inserte el nombre y los apellidos
      if(isset($_POST["titular"]) && !preg_match("/^([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){3,18}\s+([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){3,36}$/iu", $titular)) { 
        $titularErr = "Introduzca un nombre y apellidos";
      }

    //procesamos los digitos de la tarjeta de credito
    //procemos los 4 primeros digitos
    $tarjeta = (($_POST["num1"]));
        if (empty($tarjeta)) {
          $tarjetarErr = "Introduce los cuatro primeros numeros";
        } elseif (!preg_match("/^[0-9]{4}+$/", $tarjeta)) {
          $tarjetarErr = "Debes introducir los 4 primeros digitos";
        } else {
          $num1 = $tarjeta;
        }
        //procemos los 4 segundos digitos
    $tarjeta = (($_POST["num2"]));
      if (empty($tarjeta)) {
        $tarjetarErr = "Introduce los cuatro primeros numeros";
      } elseif (!preg_match("/^[0-9]{4}+$/", $tarjeta)) {
        $tarjetarErr = "Debes introducir los 4 segundos digitos";
      } else {
        $num2 = $tarjeta;
      }
    //procemos los 4 terceros digitos
    $tarjeta = (($_POST["num3"]));
        if (empty($tarjeta)) {
          $tarjetarErr = "Introduce los cuatro primeros numeros";
        } elseif (!preg_match("/^[0-9]{4}+$/", $tarjeta)) {
          $tarjetarErr = "Debes introducir los 4 terceros digitos";
        } else {
          $num3 = $tarjeta;
        }
        //procemos los 4 cuartos digitos
    $tarjeta = (($_POST["num4"]));
      if (empty($tarjeta)) {
        $tarjetarErr = "Introduce los cuatro primeros numeros";
      } elseif (!preg_match("/^[0-9]{4}+$/", $tarjeta)) {
        $tarjetarErr = "Debes introducir los 4 cuartos digitos";
      } else {
        $num4 = $tarjeta;
      }

      //procemos el codigo de seguridad de la tarjeta de credito CVV
    $cvv = (($_POST["cv"]));
      if (empty($cvv)) {
        $cvvErr = "Introduce los cuatro primeros numeros";
      } elseif (!preg_match("/^[0-9]{3}+$/", $cvv)) {
        $tarjetarErr = "Debes introducir 3 digitos del reverso";
      } else {
        $cv =  hash('sha256', $cvv);
      }

    //creamos una variable para concatenar el valor de los cuatro campos de la tarjeta de credito e poder insertarla en la base de datos
      $tarjeta_completa=$num1.$num2.$num3.$num4;
      $tarjeta_completa = hash('sha256', $tarjeta_completa);
      //echo $tarjeta_completa;

    // AÑADIMOS LOS DATOS DEL PAGO A LA TABLA DE PAGO EN LA BASE DE DATOS
      if (
        empty($fechaErr) && empty($titularErr) && empty($tarjetarErr) && empty($cvvErr)
    ) {  
      //Actualizamos el stock de la base de datos 
      $arreglo=$_SESSION['carrito']['final'];
      foreach ($arreglo as $key => $fila){
        if($fila['cantidad']>=1){
        $id=$fila['idproducto'];
        $stock=$fila['cantidad'];
      $actualiza = ControladorInstrumento::getControlador();
      $actualizar = $actualiza->actualizarstock($id,$stock);
        }
        }
      $controlador = Controladorpago::getControlador();
      $estado = $controlador->almacenarpago($titular,$tarjeta_completa,$fecha,$cv);
      $idventafe = getdate();
      $idventa=$idventafe[0];
        array_push($_SESSION['venta'],$_SESSION['carrito']['final']);
        $_SESSION['venta']['idventa']=$idventa;
        $fechacompra=date('Y-m-d h:m');
        $_SESSION['venta']['fecha']=$fechacompra;
        $_SESSION['venta']['tarjetapago']=$_POST["num4"];
        $_SESSION['pago']=[];
        $_SESSION['factura']="si";
        if ($estado) {
            alerta("Pago Procesado");
            redir("factura.php");
        } else {
            header("location: error.php");
            exit();
        }
    } else {
        alerta("Hay errores al procesar el formulario revise los errores");
    }
  }
?>

<!------ -----------------------Enlaces para el estilo del formulario de pago ----------------------------------------->
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<!---------------------------------------------- Formulario ------------------------------------------------------------>
<br><br><br><br><br><br>
<div class="container">
  <div class="row">
    <div class="span15">
    <form class="form-horizontal span11" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <fieldset>
          <legend>Pago electronico</legend>
       <!--titular de la tarjeta-->
          <div class="control-group">
            <label class="control-label">Titular Pago</label>
            <div class="controls">
              <input type="text" class="input-block-level" name="titular" pattern="([^\s][A-zÀ-ž\s]+)" title="Escribe tu nombre y primer apellido" required>
            </div>
          </div>
       <!--numero de la tarjeta-->
          <div class="control-group">
            <label class="control-label">Numero Tarjeta</label>
            <div class="controls">
              <div class="row-fluid">
                <div class="span3">
                  <input type="text" name="num1" class="input-block-level" autocomplete="off" maxlength="4" pattern="\d{4}" title="4 primeros digitos" required>
                </div>
                <div class="span3">
                  <input type="text" name="num2" class="input-block-level" autocomplete="off" maxlength="4" pattern="\d{4}" title="4 segundos digitos" required>
                </div>
                <div class="span3">
                  <input type="text" name="num3" class="input-block-level" autocomplete="off" maxlength="4" pattern="\d{4}" title="4 terceros digitos" required>
                </div>
                <div class="span3">
                  <input type="password" name="num4" class="input-block-level" autocomplete="off" maxlength="4" pattern="\d{4}" title="4 cuartos digitos" required>
                </div>
              </div>
            </div>
          </div>
       <!--fecha de caducidad de la tarjeta-->
          <div class="control-group">
            <label class="control-label">Fecha de Expiración</label>
            <div class="controls">
              <div class="row-fluid">
                <div class="span12">
                <div class="input-block-level">
                <input class="form-horizontal span2" type="date" required name="fecha" value="<?php echo date('Y-m-d', strtotime(str_replace('/', '-', $fecha))); ?>"></input>
                  <?php echo $fechaErr; ?> 
                </div>
                </div>
              </div>
            </div>
          </div>
       <!--codigo de seguridad de la tarjeta-->
          <div class="control-group">
            <label class="control-label">Código CVV</label>
            <div class="controls">
              <div class="row-fluid">
                <div class="span3">
                  <input type="password" name="cv" class="input-block-level" autocomplete="off" maxlength="3" pattern="\d{3}" title="Mirar reverso de la tarjeta los 3 digitos" required>
                </div>
                <div class="span8"></div>
              </div>
            </div>
          </div>
       <!--Botones-->
          <div class="form-actions">
            <button type="submit" name="pagar" value="pagar" class="btn btn-primary">Pagar</button>
            <a href="../index.php" type="button" class="btn">Cancelar</a>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>
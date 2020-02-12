<?php
require_once $_SERVER['DOCUMENT_ROOT']."/musihub/dirs.php";
require_once UTILITY_PATH . "funciones.php";
//variable declaradas
$fechaErr="";
//Procesamos la fecha para que cuando se procese el pago no sea una fecha inferior a la actual.
//ya que se puede estar pagando con una tarjeta caducada
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["pagar"]){
$fecha = date("d-m-Y", strtotime(filtrado($_POST["fecha"])));
$hoy =date("d-m-Y");
    if(strftime($fecha)<=strftime($hoy)){
        $fechaErr = "La fecha no puede ser inferior o igual a la fecha actual";
    }else{
        $fecha = date("d/m/Y", strtotime(filtrado($_POST["fecha"])));
    }
  }
?>

<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<br><br><br><br><br><br>
<div class="container">
  <div class="row">
    <div class="span15">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <fieldset>
          <legend>Pago electronico</legend>
       
          <div class="control-group">
            <label class="control-label">Titular Pago</label>
            <div class="controls">
              <input type="text" class="input-block-level" pattern="([^\s][A-zÀ-ž\s]+)" title="Escribe tu nombre y primer apellido" required>
            </div>
          </div>
       
          <div class="control-group">
            <label class="control-label">Numero Tarjeta</label>
            <div class="controls">
              <div class="row-fluid">
                <div class="span3">
                  <input type="text" class="input-block-level" autocomplete="off" maxlength="4" pattern="\d{4}" title="4 primeros digitos" required>
                </div>
                <div class="span3">
                  <input type="text" class="input-block-level" autocomplete="off" maxlength="4" pattern="\d{4}" title="4 segundos digitos" required>
                </div>
                <div class="span3">
                  <input type="text" class="input-block-level" autocomplete="off" maxlength="4" pattern="\d{4}" title="4 terceros digitos" required>
                </div>
                <div class="span3">
                  <input type="text" class="input-block-level" autocomplete="off" maxlength="4" pattern="\d{4}" title="4 cuartos digitos" required>
                </div>
              </div>
            </div>
          </div>
       
          <div class="control-group">
            <label class="control-label">Fecha de Expiración</label>
            <div class="controls">
              <div class="row-fluid">
                <div class="span12">
                <div class="input-block-level">
                <input type="date" required name="fecha" value="<?php echo date('Y-m-d', strtotime(str_replace('/', '-', $fecha))); ?>"></input>
                  <?php echo $fechaErr; ?> 
                </div>
                </div>
              </div>
            </div>
          </div>
       
          <div class="control-group">
            <label class="control-label">Código CVV</label>
            <div class="controls">
              <div class="row-fluid">
                <div class="span3">
                  <input type="text" class="input-block-level" autocomplete="off" maxlength="3" pattern="\d{3}" title="Mirar reverso de la tarjeta los 3 digitos" required>
                </div>
                <div class="span8">
                  <!-- screenshot may be here -->
                </div>
              </div>
            </div>
          </div>
       
          <div class="form-actions">
            <button type="submit" name="pagar" value="pagar" class="btn btn-primary">Pagar</button>
            <button type="button" class="btn">Cancelar</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>
                                
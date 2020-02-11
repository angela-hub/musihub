<?php
//fecha
$fecha = date("d-m-Y", strtotime(filtrado($_POST["fecha"])));
$hoy = date("d-m-Y", time());

// Comparamos las fechas
$fecha_pago = new DateTime($fecha);
$fecha_hoy = new DateTime($hoy);
$comparativa = $fecha_hoy->diff($fecha_pago);

if ($comparativa->format('%R%a días') < 0) {
    $fechaErr = "La fecha no puede ser inferior a la fecha actual";
    $errores[] =  $fechaErr;
} else {
    $fecha = date("d/m/Y", strtotime($fecha));
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
      <form class="form-horizontal span11">
        <fieldset>
          <legend>Pago electronico</legend>
       
          <div class="control-group">
            <label class="control-label">Titular Pago</label>
            <div class="controls">
              <input type="text" class="input-block-level" pattern="\w+ \w+.*" title="Escribe tu nombre y primer apellido" required>
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
            <button type="submit" class="btn btn-primary">Pagar</button>
            <button type="button" class="btn">Cancelar</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>
                                
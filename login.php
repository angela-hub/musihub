<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/musihub/dirs.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once CONTROLLER_PATH."ControladorAcceso.php";

//Debemos decir que no estamos identificando
$controlador = ControladorAcceso::getControlador();
$controlador->salirSesion();
?>
<!-- Barra de Navegacion -->

<?php
    
    // Procesamos la indetificación
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $controlador = ControladorAcceso::getControlador();
        $controlador->procesarIdentificacion($_POST['email'], $_POST['password']);
    }
 
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!---------------------------------------- Formulario de Login de inicio a la tienda ------------------------------------->

<div class="simple-login-container">
    <h2>Inicio de Sesion</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="row">
            <div class="col-md-12 form-group">
                <input type="email" required name="email" class="form-control" placeholder="Email">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <input type="password" required name="password" placeholder="Contraseña" class="form-control">
            </div>
        </div>
        <button type="submit" class="btn btn-primary"> <span class="glyphicon glyphicon-log-in"></span>  Entrar</button>
        <a href="./index.php" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Cancelar</a>
        </form>
        <div class="row">
            <div class="col-md-12">
                <a href="registro.php">Registrarse</a>
            </div>
        </div>
</div>

<!---------------------------------------- Estilo para la login ------------------------------------->

<style>

body{
    background-color:#5286F3;
    font-size:14px;
    color:#fff;
}
.simple-login-container{
    width:300px;
    max-width:100%;
    margin:50px auto;
}
.simple-login-container h2{
    text-align:center;
    font-size:20px;
}

.simple-login-container .btn-login{
    background-color:#FF5964;
    color:#fff;
}
a{
    color:#fff;
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio de Administracion</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<body>
<!------ Include the above in your HEAD tag ---------->
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/musihub/dirs.php";
    require_once VIEW_PATH . "../cabecera.php";
    if(isset($_SESSION['USUARIO']['email'])){
        if($_SESSION['administrador'] == "si"){
?>
<div id="fullscreen_bg" class="centrar"/>
<div class="container">
    <div class="row">
        <div class="col-lg-5 col-md-12 col-sm-8 col-xs-9 bhoechie-tab-container">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
              <ul class="list-group">
                <a href="#" class="list-group-item active">
                  <br/><br/><i class="glyphicon glyphicon-home"></i> Home<br/><br/>
                  </a>
                <a href="#" class="list-group-item ">
                  <br/><br/><i class="glyphicon glyphicon-user"></i> Usuarios<br/><br/>
                </a>
                <a href="#" class="list-group-item">
                  <br/><br/><h4 class="glyphicon glyphicon-music"></h4> Instrumentos<br/><br/>
                </a>
              </ul>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
                <!-- flight section -->
                <div class="bhoechie-tab-content active">
                    <center>
                      <h1 class="glyphicon glyphicon-wrench" style="font-size:14em;color:#00001a"></h1>
                      <h2 style="margin-top: 0;color:#00001a">Bienvenido a la página de</h2>
                      <h3 style="margin-top: 0;color:#00001a">Administracion</h3>
                    </center>
                </div>
                <!-- train section -->
                <div class="bhoechie-tab-content">
                    <center>
                      <h1 class="glyphicon glyphicon-user" style="font-size:12em;color:#00001a"></h1>
                      <h2 style="margin-top: 0;color:#00001a"><a href="/musihub/admin/vistas_usuarios/listado_usu.php" class="btn btn-sm btn-primary btn-block" role="button">Ver</a></h2>
                      <h3 style="margin-top: 0;color:#00001a">Gestion de Usuarios</h3>
                    </center>
                </div>
    
                <!-- hotel search -->
                <div class="bhoechie-tab-content">
                    <center>
                      <h1 class="glyphicon glyphicon-music" style="font-size:12em;color:#00001a"></h1>
                      <h2 style="margin-top: 0;color:#00001a"><a href="/musihub/admin/vistas_instrumentos/listado.php" class="btn btn-sm btn-primary btn-block" role="button">Ver</a></h2>
                      <h3 style="margin-top: 0;color:#00001a">Gestion de Instrumentos</h3>
                    </center>
                </div>
            </div>
        </div>
  </div>
</div>
</body>
</html>
<style>
    .centrar
	{
		position: absolute;
		/*nos posicionamos en el centro del navegador*/
		top:40%;
		left:40%;
		/*determinamos una anchura*/
		width:400px;
		/*indicamos que el margen izquierdo, es la mitad de la anchura*/
		margin-left:-150px;
		/*determinamos una altura*/
		height:300px;
		/*indicamos que el margen superior, es la mitad de la altura*/
		margin-top:-150px;
		padding:5px;
	}
.fullscreen_bg {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-size: cover;
    background-position: 50% 50%;
    background-image: url('http://blog.transfer-iphone-recovery.com/images/photo-with-blur-background.jpg');
    background-repeat:repeat;
  }
/*  bhoechie tab */
div.bhoechie-tab-container{
  z-index: 10;
  background-color: #ffffff;
  padding: 0 !important;
  border-radius: 4px;
  -moz-border-radius: 4px;
  border:1px solid #ddd;
  margin-top: 20px;
  margin-left: 50px;
  -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  box-shadow: 0 6px 12px rgba(0,0,0,.175);
  -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  background-clip: padding-box;
  opacity: 0.97;
  filter: alpha(opacity=97);
}
div.bhoechie-tab-menu{
  padding-right: 0;
  padding-left: 0;
  padding-bottom: 0;
}
div.bhoechie-tab-menu ul.list-group{
  margin-bottom: 0;
  list-style:none;
}
div.bhoechie-tab-menu ul.list-group>a{
  margin-bottom: 0;
  text-align:left;
}
div.bhoechie-tab-menu ul.list-group>a .glyphicon,
div.bhoechie-tab-menu ul.list-group>a .fa {
  color: #00001a;
}
div.bhoechie-tab-menu ul.list-group>a:first-child{
  border-top-right-radius: 0;
  -moz-border-top-right-radius: 0;
}
div.bhoechie-tab-menu ul.list-group>a:last-child{
  border-bottom-right-radius: 0;
  -moz-border-bottom-right-radius: 0;
}
div.bhoechie-tab-menu ul.list-group>a.active,
div.bhoechie-tab-menu ul.list-group>a.active .glyphicon,
div.bhoechie-tab-menu ul.list-group>a.active .fa{
  background-color: #004c99;
  background-image: #5A55A3;
  color: #ffffff;
}
div.bhoechie-tab-menu ul.list-group>a.active:after{
  content: '';
  position: absolute;
  left: 100%;
  top: 50%;
  margin-top: -13px;
  border-left: 0;
  border-bottom: 13px solid transparent;
  border-top: 13px solid transparent;
  border-left: 10px solid #5A55A3;
}

div.bhoechie-tab-content{
  background-color: #ffffff;
  /* border: 1px solid #eeeeee; */
  padding-left: 20px;
  padding-top: 10px;
}

div.bhoechie-tab div.bhoechie-tab-content:not(.active){
  display: none;
}
</style>
<script>
$(document).ready(function() {
    $("div.bhoechie-tab-menu>ul.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
});
</script>
<?php
}else{
    header("location:/musihub/error403.php");
}
}else{
    header("location:/musihub/error403.php");
}
?>

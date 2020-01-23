<?php
session_start();
if(isset($_SESSION['USUARIO']['email'])){
    if($_SESSION['administrador'] == "si"){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio de Administracion</title>
</head>
<body>
<h1>Administración de la Tienda MusiHub</h1>
    <a href="/musihub/admin/vistas_usuarios/listado_usu.php">Gestión de Usuarios</a><br>
    <a href="/musihub/admin/vistas_instrumentos/listado.php">Gestión de Instrumentos</a><br>
    <a href="/musihub/index.php">Tienda</a>
</body>
</html>
<?php
}else{
    header("location:/musihub/error403.php");
}
}else{
    header("location:/musihub/error403.php");
}
?>

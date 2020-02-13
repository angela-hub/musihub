<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once VIEW_PATH . "../cabecera.php";
require_once CONTROLLER_PATH . "ControladorCarrito.php";

// Compramos si existe el campo ID
/*
if (isset($_GET["id"]) && !empty(trim($_GET["id"])) && isset($_GET["page"]) && !empty(trim($_GET["page"]))) {
    $id = decode($_GET["id"]);
    $page = decode($_GET["page"]);
    // Cargamos el controlador
    $controlador = ControladorInstrumento::getControlador();
    $producto= $controlador->buscarinstrumentoid($id);
    // Lo insertamos y vamos a la página anterior
    $carrito = ControladorCarrito::getControlador();
    if ($carrito->insertarLineaCarrito($producto,1)) {
        // si es correcto recarga la página y actualizamos la cookie
        // Volvemos atras
        header("location:".$page);
        exit();
    }

}

//si no existe el usuario lo enviamos a error para que no haga nada
if (is_null($producto)) {
    // hay un error
    alerta("Operación no permitida", "error.php");
    exit();
}
*/
//Empieza
if (isset($_SESSION['USUARIO']['email'])) {
    $conexion= conectar();
    $id= $_GET['id'];
    $id= decode($id);
    alerta($id);
    exit();
    $consulta= "SELECT * FROM productos WHERE idproducto=" . $id;
    $respuesta= mysql_fetch_array($conexion,$consulta);
    if ($respuesta){
        $fila= mysqli_fetch_array($respuesta);
        if(!isset($_SESSION['carrito'])){
            $arreglo[0]['idproducto']=$fila['idproducto'];
            $arreglo[0]['nomProducto']=$fila['nomProducto'];
            $arreglo[0]['cliente']=$_SESSION['usuario'];
            $arreglo[0]['fecha']=date('Y-m-d h:m');
            $arreglo[0]['precio']=$fila['precio'];
            $arreglo[0]['foto']=$fila['foto'];
            $arreglo[0]['marca']=$fila['marca'];
            $arreglo[0]['cantidad']=1;
            $_SESSION['carrito']=$arreglo;
        }else{
            $arreglo=$_SESSION['carrito'];
            $cant= count($arreglo);
            $arreglo[$cant + 1]['idproducto']=$fila['idproducto'];
            $arreglo[$cant + 1]['nomProducto']=$fila['nomProducto'];
            $arreglo[$cant + 1]['cliente']=$_SESSION['usuario'];
            $arreglo[$cant + 1]['fecha']=date('Y-m-d h:m');
            $arreglo[$cant + 1]['precio']=$fila['precio'];
            $arreglo[$cant + 1]['foto']=$fila['foto'];
            $arreglo[$cant + 1]['marca']=$fila['marca'];
            $arreglo[$cant + 1]['cantidad']=1;
            $_SESSION['carrito']=$arreglo;
        }
    }
    header("location:".$page);
}
?>
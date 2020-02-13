<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once "../utilidades/funciones.php";
require_once CONTROLLER_PATH . "ControladorInstrumento.php";
require_once VIEW_PATH . "../cabecera.php";
//require_once CONTROLLER_PATH . "ControladorCarrito.php";

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
    $id= decode($_GET['id']);
    $controlador = ControladorInstrumento::getControlador();
    $estado = $controlador->buscarinstrumentoid($id);
    if ($estado){
        if(!isset($_SESSION['carrito'])){
            $arreglo[0]['idproducto']=$estado->getid();
            $arreglo[0]['nomProducto']=$estado->getnombre();
            $arreglo[0]['cliente']=$_SESSION['USUARIO']['email'];
            $arreglo[0]['fecha']=date('Y-m-d h:m');
            $arreglo[0]['precio']=$estado->getprecio();
            $arreglo[0]['foto']=$estado->getimagen();
            $arreglo[0]['marca']=$estado->getdistribuidor();
            $arreglo[0]['cantidad']=1;
            $_SESSION['carrito']=$arreglo;
            $fili[]= $arreglo[0]['idproducto'];
            $_SESSION['carrito']['id']=$fili;
            $final=array_search($estado->getid(),$fili);
            alerta($final);
            echo "Esto es fili";
            var_dump($fili);
            echo "Ya";
            //$_SESSION['carrito']['id']=$estado->getid();
            $fila=array_search($estado->getid(),$_SESSION['carrito']['id']);
            alerta($fila);
        }elseif(array_search($estado->getid(),$_SESSION['carrito']['id'])!="" || array_search($estado->getid(),$_SESSION['carrito']['id'])!=0){
            //alerta("Entra aqui");
            alerta("Entra");
            $arreglo=$_SESSION['carrito'];
            //$arreglo[0]['idproducto']=$estado->getid();
            //alerta($arreglo[0]['idproducto']);
            //alerta($estado->getid());
            /*
            if($arreglo[0]['idproducto']==$estado->getid()){
                alerta("Existe");
            }
            */
            $cant= count($arreglo);
            $arreglo[0]['idproducto']=$estado->getid();
            $arreglo[0]['nomProducto']=$estado->getnombre();
            $arreglo[0]['cliente']=$_SESSION['USUARIO']['email'];
            $arreglo[0]['fecha']=date('Y-m-d h:m');
            $arreglo[0]['precio']=$estado->getprecio();
            $arreglo[0]['foto']=$estado->getimagen();
            $arreglo[0]['marca']=$estado->getdistribuidor();
            $arreglo[0]['cantidad']=$arreglo[0]['cantidad']+1;
            //$_SESSION['carrito']['id']['cantidad']=$_SESSION['carrito']['id']['cantidad']+1;
            $_SESSION['carrito']=$arreglo;
            //$fili[]=$_SESSION['carrito']['id'];
            
            //alerta($arreglo[$cant +1]['idproducto']);
            //array_push($fili,$arreglo[$cant +1]['idproducto']);
            //$_SESSION['carrito']['id']=$fili;
            echo "Esto es fili:";
            /*$numero=$arreglo[$cant +1]['idproducto'];
            alerta($numero);
            alerta("14");
            $final=array_search($id,$fili);
            if($final==1){
                $arreglo[0]['cantidad']= $arreglo[0]['cantidad']+1;
            }
            alerta($final);
            */var_dump($fili);
            
        }else{
            
            $arreglo=$_SESSION['carrito'];
            $cant= count($arreglo);
            $arreglo[$cant +1]['idproducto']=$estado->getid();
            $arreglo[$cant +1]['nomProducto']=$estado->getnombre();
            $arreglo[$cant +1]['cliente']=$_SESSION['USUARIO']['email'];
            $arreglo[$cant +1]['fecha']=date('Y-m-d h:m');
            $arreglo[$cant +1]['precio']=$estado->getprecio();
            $arreglo[$cant +1]['foto']=$estado->getimagen();
            $arreglo[$cant +1]['marca']=$estado->getdistribuidor();
            $arreglo[$cant +1]['cantidad']=1;
            $_SESSION['carrito']=$arreglo;
            $fili=$_SESSION['carrito']['id'];
            var_dump($_SESSION['carrito']['id']);
            array_push($fili,$arreglo[$cant +1]['idproducto']);
            $_SESSION['carrito']['id']=$fili;
            $hola=array_search($estado->getid(),$_SESSION['carrito']['id']);
            alerta($hola);
        }
    }
    $fila=array_search($estado->getid(),$_SESSION['carrito']['id']);
            alerta($fila);
    echo "<table><th></th><th>Nombre</th><th>Marca</th><th>Precio</th>
        <th>Cantidad</th>";
        foreach ($arreglo as $key => $fila){
            $foto = $fila['foto'];
            echo "<tr><td><img src='../imagenes/fotos/" . $foto . " '></td>";
            echo "<td>" . $fila['nomProducto'] . "</td>";
            echo "<td>" . $fila['marca'] . "</td>";
            echo "<td>" . $fila['precio'] . "</td>";
            echo "<td>" . $fila['cantidad'] . "</td>";
            echo "<tr>";
        }
        echo "</table>";
    //var_dump($_SESSION['carrito']);
}
?>
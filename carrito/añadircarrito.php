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
    if(!isset($_SESSION['carrito']['id'])){
        $_SESSION['carrito']['id']=[];
        $_SESSION['carrito']['prueba']=[];
    }else{
    }
    //print_r($_SESSION['carrito']['prueba']);
    //exit;
    
    //array_push($_SESSION['carrito']['id'],$id); 
    
    if ($estado){
        if(!isset($_SESSION['carrito']['final'])){
            //alerta("Primero");
            $arreglo[$id]['idproducto']=$estado->getid();
            $arreglo[$id]['nomProducto']=$estado->getnombre();
            $arreglo[$id]['cliente']=$_SESSION['USUARIO']['email'];
            $arreglo[$id]['fecha']=date('Y-m-d h:m');
            $arreglo[$id]['precio']=$estado->getprecio();
            $arreglo[$id]['foto']=$estado->getimagen();
            $arreglo[$id]['marca']=$estado->getdistribuidor();
            $arreglo[$id]['cantidad']=1;
            $_SESSION['cantidad']=1;
            $_SESSION['carrito']['final']=$arreglo;
            array_push($_SESSION['carrito']['id'],$estado->getid());
            $_SESSION['total'][$id]=$estado->getprecio();
            //Total
            $final=array_sum($_SESSION['total']);
            $_SESSION['precio']=$final;
            
        }
        elseif(array_key_exists($estado->getid(),$_SESSION['carrito']['prueba'])!="" || 
                array_key_exists($estado->getid(),$_SESSION['carrito']['prueba'])!=0){
            //alerta("Entra aqui");
            //alerta("Segundo");
            //alerta("Entra");
            $arreglo=$_SESSION['carrito']['final'];
            $arreglo[$id]['idproducto']=$estado->getid();
            $arreglo[$id]['nomProducto']=$estado->getnombre();
            $arreglo[$id]['cliente']=$_SESSION['USUARIO']['email'];
            $arreglo[$id]['fecha']=date('Y-m-d h:m');
            $arreglo[$id]['precio']=$estado->getprecio();
            $arreglo[$id]['foto']=$estado->getimagen();
            $arreglo[$id]['marca']=$estado->getdistribuidor();
            $arreglo[$id]['cantidad']=$_SESSION['carrito']['final'][$id]['cantidad']+1;
            $_SESSION['cantidad']=$_SESSION['cantidad']+1;
            $_SESSION['carrito']['final']=$arreglo;
            array_push($_SESSION['carrito']['id'],$estado->getid());
            //$arreglo[0]['idproducto']=$estado->getid();
            //alerta($arreglo[0]['idproducto']);
            //alerta($estado->getid());
            /*
            if($arreglo[0]['idproducto']==$estado->getid()){
                alerta("Existe");
            }
            */
            //$arreglo[0]['cantidad']=$arreglo[0]['cantidad']+1;
            //$_SESSION['carrito']['id']['cantidad']=$_SESSION['carrito']['id']['cantidad']+1;
            //$_SESSION['carrito']=$arreglo;
            array_push($_SESSION['carrito']['id'],$estado->getid());
            array_push($_SESSION['total'][$id],$estado->getprecio());
            $precio=$_SESSION['carrito']['final'][$id]['precio'];
            if(!isset($_SESSION['total'][$id])|| empty($_SESSION['total'][$id])){
                $_SESSION['total'][$id]=$precio;
            }else{
                $_SESSION['total'][$id]=$_SESSION['total'][$id]+$precio;
            }
            //$fili=$_SESSION['carrito']['id'];
            //$fili[]=$_SESSION['carrito']['id'];
            //array_push($fili,$silo);
            //alerta($arreglo[$cant +1]['idproducto']);
            //array_push($fili,$arreglo[$cant +1]['idproducto']);
            //$_SESSION['carrito']['id']=$fili;
            //$_SESSION['carrito']['id']=$fili;
            //echo "Esto es fili:";
            /*$numero=$arreglo[$cant +1]['idproducto'];
            alerta($numero);
            alerta("14");
            $final=array_search($id,$fili);
            if($final==1){
                $arreglo[0]['cantidad']= $arreglo[0]['cantidad']+1;
            }
            alerta($final);
            */var_dump($fili);
            $final=array_sum($_SESSION['total']);
            $_SESSION['precio']=$final;
            
        }else{
            //alerta("Tercero");
            $arreglo=$_SESSION['carrito']['final'];
            $cant= count($arreglo);
            $silo=$arreglo[$id]['idproducto']=$estado->getid();
            $arreglo[$id]['nomProducto']=$estado->getnombre();
            $arreglo[$id]['cliente']=$_SESSION['USUARIO']['email'];
            $arreglo[$id]['fecha']=date('Y-m-d h:m');
            $arreglo[$id]['precio']=$estado->getprecio();
            $arreglo[$id]['foto']=$estado->getimagen();
            $arreglo[$id]['marca']=$estado->getdistribuidor();
            $arreglo[$id]['cantidad']=1;
            $_SESSION['cantidad']=$_SESSION['cantidad']+1;
            array_push($_SESSION['carrito']['id'],$estado->getid());
            $_SESSION['carrito']['final']=$arreglo;
            $fili=$_SESSION['carrito']['id'];
            var_dump($_SESSION['carrito']['id']);
            $_SESSION['carrito']['id']=$fili;
            $hola=array_search($estado->getid(),$_SESSION['carrito']['id']);
            $_SESSION['total'][$id]=$estado->getprecio();
            $final=array_sum($_SESSION['total']);
            $_SESSION['precio']=$final;
            //alerta($hola);
        }
    }
echo "Este es el print";
$numero=contarValoresArray($_SESSION['carrito']['id']);
$_SESSION['carrito']['prueba']=$numero;
        header("location:/musihub/index.php");  
    //var_dump($_SESSION['carrito']);
}
?>
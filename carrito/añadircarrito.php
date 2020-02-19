<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once "../utilidades/funciones.php";
require_once CONTROLLER_PATH . "ControladorInstrumento.php";
require_once VIEW_PATH . "../cabecera.php";

//En primer lugar comprobamos si existe la sesion iniciada del usuario, descodificamos el id enviado por GET y buscamos en la base de datos el instrumento con la ID pasada
if (isset($_SESSION['USUARIO']['email'])) {
    $id= decode($_GET['id']);
    $controlador = ControladorInstrumento::getControlador();
    $estado = $controlador->buscarinstrumentoid($id);
    //Si no existe la sesion carrito id declaramos dicha sesion y la sesion carrito prueba y las dejamos vacias
    if(!isset($_SESSION['carrito']['id'])){
        $_SESSION['carrito']['id']=[];
        $_SESSION['carrito']['prueba']=[];
    }else{
    }
    //print_r($_SESSION['carrito']['prueba']);
    //exit;
    
    //array_push($_SESSION['carrito']['id'],$id); 
    //Cogemos el estock del que dispone el instrumento
    $stock=$estado->getstockinicial();
    //Comprobamos si el stock del que dispone es mayor que el que se esta intentando comprar en dicho caso procedera a agregarlo a la sesion del carrito
    if($stock>$_SESSION['carrito']['final'][$id]['cantidad']){
    if ($estado){
        //Si no existe la sesion carrito final se procede a crearla agregandole todos los datos del instrumento que se ven a continuacion como el id,nombre, etc
        if(!isset($_SESSION['carrito']['final'])){
            $arreglo[$id]['idproducto']=$estado->getid();
            $arreglo[$id]['nomProducto']=$estado->getnombre();
            $arreglo[$id]['cliente']=$_SESSION['USUARIO']['email'];
            $arreglo[$id]['fecha']=date('Y-m-d h:m');
            $arreglo[$id]['precio']=$estado->getprecio();
            $arreglo[$id]['foto']=$estado->getimagen();
            $arreglo[$id]['marca']=$estado->getdistribuidor();
            $arreglo[$id]['cantidad']=1;
            //Ponemos la sesion cantidad que sera la que cuente el total de todas las cantidades a 1 ya que es el primero que se mete
            $_SESSION['cantidad']=1;
            $_SESSION['carrito']['final']=$arreglo;
            //Añadimos a la sesion carrito id el id del producto
            array_push($_SESSION['carrito']['id'],$estado->getid());
            $_SESSION['total'][$id]=$estado->getprecio();
            //Sumamos todas las cantidades de la sesion total y lo metemos en la variable final la cual luego se le asgina a la sesion precio
            $final=array_sum($_SESSION['total']);
            $_SESSION['precio']=$final;
            
        }
        //En el caso de que ya exista dicha id en el carrito se añadiran todos los campos de nuevo pero la cantidad lo que hara en vez de ponerla en 1 se le sumara
        //1 a la cantidad que ya tenga
        elseif(array_key_exists($estado->getid(),$_SESSION['carrito']['prueba'])!="" || 
                array_key_exists($estado->getid(),$_SESSION['carrito']['prueba'])!=0){
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
            array_push($_SESSION['total'][$id],$estado->getprecio());
            $precio=$_SESSION['carrito']['final'][$id]['precio'];
            //Si no existe la sesion total de dicha id o se encuentra vacia lo que se hara es asignarle a dicha sesion el precio del objeto y si existe se lo sumara a la sesion
            if(!isset($_SESSION['total'][$id])|| empty($_SESSION['total'][$id])){
                $_SESSION['total'][$id]=$precio;
            }else{
                $_SESSION['total'][$id]=$_SESSION['total'][$id]+$precio;
            }
            var_dump($fili);
            $final=array_sum($_SESSION['total']);
            $_SESSION['precio']=$final;
            //Si existe la sesion carrito pero no es el mismo instrumento el que se esta añadiendo se hara lo mismo que si no se encuentra la sesion pero esta vez le sumaremos
            // a la sesion cantidad 1
        }else{
            $arreglo=$_SESSION['carrito']['final'];
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
            $_SESSION['carrito']['id']=$fili;
            $hola=array_search($estado->getid(),$_SESSION['carrito']['id']);
            $_SESSION['total'][$id]=$estado->getprecio();
            $final=array_sum($_SESSION['total']);
            $_SESSION['precio']=$final;
            //alerta($hola);
        }
    }
$numero=contarValoresArray($_SESSION['carrito']['id']);
$_SESSION['carrito']['prueba']=$numero;
        header("location:/musihub/index.php");  
}else{
    header("location:/musihub/sinstock.php");
}
    //var_dump($_SESSION['carrito']);
}
?>
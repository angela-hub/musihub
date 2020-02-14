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
    //array_push($_SESSION['carrito']['id'],$id);

    if ($estado){
        if(!isset($_SESSION['carrito']['final'])){
            alerta("Primero");
            $arreglo[0]['idproducto']=$estado->getid();
            $arreglo[0]['nomProducto']=$estado->getnombre();
            $arreglo[0]['cliente']=$_SESSION['USUARIO']['email'];
            $arreglo[0]['fecha']=date('Y-m-d h:m');
            $arreglo[0]['precio']=$estado->getprecio();
            $arreglo[0]['foto']=$estado->getimagen();
            $arreglo[0]['marca']=$estado->getdistribuidor();
            $arreglo[0]['cantidad']=1;
            $_SESSION['carrito']['final']=$arreglo;
            array_push($_SESSION['carrito']['id'],$estado->getid());
        
            
        }
        elseif(array_key_exists($estado->getid(),$_SESSION['carrito']['prueba'])!="" || array_key_exists($estado->getid(),$_SESSION['carrito']['prueba'])!=0){
            //alerta("Entra aqui");
            alerta("Segundo");
            alerta("Entra");
            $arreglo=$_SESSION['carrito']['final'];
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
            
        }else{
            alerta("Tercero");
            $arreglo=$_SESSION['carrito']['final'];
            $cant= count($arreglo);
            $silo=$arreglo[$cant +1]['idproducto']=$estado->getid();
            $arreglo[$cant +1]['nomProducto']=$estado->getnombre();
            $arreglo[$cant +1]['cliente']=$_SESSION['USUARIO']['email'];
            $arreglo[$cant +1]['fecha']=date('Y-m-d h:m');
            $arreglo[$cant +1]['precio']=$estado->getprecio();
            $arreglo[$cant +1]['foto']=$estado->getimagen();
            $arreglo[$cant +1]['marca']=$estado->getdistribuidor();
            $arreglo[$cant +1]['cantidad']=1;
            array_push($_SESSION['carrito']['id'],$estado->getid());
            $_SESSION['carrito']['final']=$arreglo;
            $fili=$_SESSION['carrito']['id'];
            var_dump($_SESSION['carrito']['id']);
            $_SESSION['carrito']['id']=$fili;
            $hola=array_search($estado->getid(),$_SESSION['carrito']['id']);
            alerta($hola);
        }
    }
    function contarValoresArray($array)
{
	$contar=array();
 
	foreach($array as $value)
	{
		if(isset($contar[$value]))
		{
			$contar[$value]+=1;
		}else{
			// si no existe lo añadimos al array
			$contar[$value]=1;
		}
	}
	return $contar;
}

echo "Este es el print";
$numero=contarValoresArray($_SESSION['carrito']['id']);
$_SESSION['carrito']['prueba']=$numero;
print_r($numero);

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
            foreach($numero as $k => $v){
                if($k==$fila['idproducto']){
                    echo "<td>" . $v . "</td>";
                    alerta($v);
                }
            }
            //echo "<td>" . $fila['idproducto'] . "</td>";
            echo "<tr>";
            echo "</table>";
        }
        
            
            exit();
    //var_dump($_SESSION['carrito']);
}
?>
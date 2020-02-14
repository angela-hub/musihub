<?php
//Directorios para trabajar
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once UTILITY_PATH . "funciones.php";
require_once CONTROLLER_PATH . "ControladorBD.php";
require_once CONTROLLER_PATH . "ControladorPago.php";

session_start();

if (isset($_SESSION['USUARIO']['email'])) {
    //$controlador = Controladorpago::getControlador();
    //$estado = $controlador->almacenarcarrrito($nombre,$distribuidor,$precio,$cantidad);
    if (isset($_POST['borrar'])) {
        $numero=restarValoresArray($_SESSION['carrito']['prueba']);
        $_SESSION['carrito']['prueba']=$numero;
    }


    $numero=contarValoresArray($_SESSION['carrito']['id']);
    $_SESSION['carrito']['prueba']=$numero;
    if(isset($_SESSION['carrito'])){
        $arreglo=$_SESSION['carrito']['final'];
        echo "<table><th></th><th>Instrumento</th><th>Distribuidor</th><th>Precio</th><th>Cantidad</th><th>Funcion</th>";
        foreach ($arreglo as $key => $fila){
            $foto = $fila['foto'];
            echo "<tr><td><img src='../imagenes/fotos/" . $foto . "' width='70px' height='70'></td>";
            echo "<td>" . $fila['nomProducto'] . "</td>";
            echo "<td>" . $fila['marca'] . "</td>";
            echo "<td>" . $fila['precio'] . "</td>";
            foreach($numero as $k => $v){
                if($k==$fila['idproducto']){
                    echo "<td>" . $v . "</td>";
                    //alerta($v);
                }
            }
            ?>
            <td><form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>"
                                      method="post">
                                    <button class="btn btn-danger" type="submit" name="borrar"
                                            title='Vaciar Carrito'
                                            onclick="return confirm('¿Seguro que desea vaciar el carrito?')">
                                        <span class='glyphicon glyphicon-trash'></span> Vaciar carrito</span>
                                    </button>
                                </form></td>
              <?php                  
            
        }
        //echo "<td>" . $fila['idproducto'] . "</td>";
        echo "<tr>";
        echo "</table>";
    }
    else{
        echo "No hay productos en el carrito";
    }
}
?>

<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    table {
        font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
        font-size: 12px;
        margin: 1.5%;
        width: 97%;
        border-collapse: collapse;
        border-bottom: 4px solid #aabcfe;
    }


    th {
        font-size: 13px;
        font-weight: normal;
        padding: 8px;
        background: #b9c9fe;
        border-top: 4px solid #aabcfe;
        border-bottom: 1px solid #fff;
        color: #039;
    }

    .centrado {
        text-align: center;
    }

    td {
        text-align: center;
        padding: 8px;
        background: #e8edff;
        border-bottom: 1px solid #d0dafd;
        color: #669;
        border-top: 1px solid transparent;
    }

    tr:hover td {
        background: #d0dafd;
        color: #339;
    }

    .letra:hover {
        background: #d0dafd;
        color: black;
    }
</style>
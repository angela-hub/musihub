<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once CONTROLLER_PATH . "ControladorInstrumento.php";
require_once CONTROLLER_PATH . "ControladorUsuario.php";
require_once CONTROLLER_PATH . "ControladorVenta.php";
require_once MODEL_PATH . "instrumento.php";
require_once VENDOR_PATH . "autoload.php";
use Spipu\Html2Pdf\HTML2PDF;

class ControladorDescarga
{
    private $fichero;
    static private $instancia = null;

    private function __construct()
    {
        //echo "Conector creado";
    }

    /**
     * Patrón Singleton. Ontiene una instancia del Controlador de Descargas
     * @return instancia de conexion
     */

    public static function getControlador()
    {
        if (self::$instancia == null) {
            self::$instancia = new ControladorDescarga();
        }
        return self::$instancia;
    }
//----------------------------------------------------------------------------------------------------------
// Con esta funcion descargaremos informacion en un fichero TXT.
public function descargarTXT()
{
    $this->fichero = "Instrumentos.txt";
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . $this->fichero . "");
// cogemos la funcion de listar instrumento del controlador para recorrrer los datos de cada instrumento
    $controlador = ControladorInstrumento::getControlador();
    $lista = $controlador->listarInstrumento("", "");

    if (!is_null($lista) && count($lista) > 0) {
        foreach ($lista as &$instrumento) {
            echo " -- Nombre: " . $instrumento->getnombre() . "  -- referencia: " . $instrumento->getreferencia() . "  -- distribuidor: " . $instrumento->getdistribuidor() .
            " -- tipo: " . $instrumento->gettipo() . " -- precio: " . $instrumento->getprecio() . " -- descuento: " . $instrumento->getdescuento() .
            " --stockinicial: " . $instrumento->getstockinicial();
        }
    } else {
        echo "No se ha encontrado datos de Instrumentos";
    }
}
//----------------------------------------------------------------------------------------------------------
// Con esta funcion descargaremos informacion en un fichero TXT.
public function descargarTXTUsu()
{
    $this->fichero = "Usuarios.txt";
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . $this->fichero . "");

    $controlador = ControladorUsuario::getControlador();
    $lista = $controlador->listarUsuarios("", "");

    if (!is_null($lista) && count($lista) > 0) {
        foreach ($lista as &$usuario) {
            echo " -- Nombre: " . $usuario->getnombre() . "  -- apellidos: " . $usuario->getapellidos() . "  -- email: " . $usuario->getemail() .
            " -- password: " . $usuario->getpassword() . " -- administrador: " . $usuario->getadministrador() . " -- telefono: " . $usuario->gettelefono() .
            " --fechade alta: " . $usuario->getfecha_alta() . " -- foto: " . $usuario->getfoto();
        }
    } else {
        echo "No se ha encontrado datos de Usuarios";
    }
}
//---------------------------------------------------------------------------------------------------------
// Con esta funcion nos generara un fichero JSON.
    public function descargarJSON()
    {
        $this->fichero = "Instrumentos.json";
        header("Content-Type: application/octet-stream");
        header('Content-type: application/json');
        //header("Content-Disposition: attachment; filename=" . $this->fichero . ""); //archivo de salida

        $controlador = ControladorInstrumento::getControlador();
        $lista = $controlador->listarInstrumento("", "");
        $sal = [];
        foreach ($lista as $al) {
            $sal[] = $this->json_encode_private($al);
        }
        echo json_encode($sal);
    }
//----------------------------------------------------------------------------------------------------------
// Con esta funcion nos generara un fichero JSON.
    public function descargarJSONUsu()
    {
        $this->fichero = "Usuarios.json";
        header("Content-Type: application/octet-stream");
        header('Content-type: application/json');
        //header("Content-Disposition: attachment; filename=" . $this->fichero . ""); //archivo de salida

        $controlador = ControladorUsuario::getControlador();
        $lista = $controlador->listarUsuarios("", "");
        $sal = [];
        foreach ($lista as $al) {
            $sal[] = $this->json_encode_private($al);
        }
        echo json_encode($sal);
    }
//----------------------------------------------------------------------------------------------------------

    private function json_encode_private($object)
    {
        $public = [];
        $reflection = new ReflectionClass($object);
        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $public[$property->getName()] = $property->getValue($object);
        }
        return json_encode($public);
    }
//-----------------------------------------------------------------------------------------------------------
// Con esta funcion nos generara en un fichero XML.
    public function descargarXML(){
        $this->fichero = "Instrumentos.xml";
        $lista = $controlador = ControladorInstrumento::getControlador();
        $lista = $controlador->listarInstrumentos("", "");
        $doc = new DOMDocument('1.0', 'UTF-8');
        $instrumentos = $doc->createElement('usuarios');

        foreach ($lista as $a) {
            $instrumento = $doc->createElement('instrumento');
            $instrumento->appendChild($doc->createElement('nombre', $a->getnombre()));
            $instrumento->appendChild($doc->createElement('referencia', $a->getreferencia()));
            $instrumento->appendChild($doc->createElement('distribuidor', $a->getdistribuidor()));
            $instrumento->appendChild($doc->createElement('tipo', $a->gettipo()));
            $instrumento->appendChild($doc->createElement('precio', $a->getprecio()));
            $instrumento->appendChild($doc->createElement('descuento', $a->getdescuento()));
            $instrumento->appendChild($doc->createElement('stockinicial', $a->getstockinicial()));
            $instrumento->appendChild($doc->createElement('imagen', $a->getimagen()));

            $instrumentos->appendChild($instrumento);
        }

        $doc->appendChild($instrumentos);
        header('Content-type: application/xml');
        echo $doc->saveXML();

        exit;
    }
//----------------------------------------------------------------------------------------------------------
// Con esta funcion nos generara en un fichero XML.
    public function descargarXMLUsu(){
        $this->fichero = "Usuarios.xml";
        $lista = $controlador = ControladorUsuario::getControlador();
        $lista = $controlador->listarUsuarios("", "");
        $doc = new DOMDocument('1.0', 'UTF-8');
        $usuarios = $doc->createElement('usuarios');

        foreach ($lista as $a) {
            $usuario = $doc->createElement('usuario');
            $usuario->appendChild($doc->createElement('nombre', $a->getnombre()));
            $usuario->appendChild($doc->createElement('apellidos', $a->getapellidos()));
            $usuario->appendChild($doc->createElement('email', $a->getemail()));
            $usuario->appendChild($doc->createElement('password', $a->getpassword()));
            $usuario->appendChild($doc->createElement('administrador', $a->getadministrador()));
            $usuario->appendChild($doc->createElement('telefono', $a->gettelefono()));
            $usuario->appendChild($doc->createElement('fecha_alta', $a->getfecha_alta()));
            $usuario->appendChild($doc->createElement('foto', $a->getfoto()));

            $usuarios->appendChild($usuario);
        }

        $doc->appendChild($usuarios);
        header('Content-type: application/xml');
        echo $doc->saveXML();

        exit;
    }
//-------------------------------------------------------------------------------------------------------------
// Con esta funcion descargaremos en PDF en la parte de administracion
    public function descargarPDF(){
        $sal ='<h2 class="pull-left">Fichas de Instrumentos</h2>';
        $lista = $controlador = ControladorInstrumento::getControlador();
        $lista = $controlador->listarInstrumento("", "");
        if (!is_null($lista) && count($lista) > 0) {
            $sal.="<table class='table table-bordered table-striped'>";
            $sal.="<thead>";
            $sal.="<tr>";
            $sal.="<th>Nombre</th>";
            $sal.="<th>Referencia</th>";
            $sal.="<th>distribuidor</th>";
            $sal.="<th>tipo</th>";
            $sal.="<th>precio</th>";
            $sal.="<th>descuento</th>";
            $sal.="<th>stockinicial</th>";
            $sal.="<th>Imagen</th>";
            $sal.="</tr>";
            $sal.="</thead>";
            $sal.="<tbody>";
        

            foreach ($lista as $instrumento) {
                $sal.="<tr>";
                $sal.="<td>" . $instrumento->getnombre() . "</td>";
                $sal.="<td>" . $instrumento->getreferencia() . "</td>";
                $sal.="<td>" . $instrumento->getdistribuidor() . "</td>";
                $sal.="<td>" . $instrumento->gettipo() . "</td>";
                $sal.="<td>" . $instrumento->getprecio() . "</td>";
                $sal.="<td>" . $instrumento->getdescuento() . "</td>";
                $sal.="<td>" . $instrumento->getstockinicial() . "</td>";
                // Para sacar una imagen hay que decirle el directorio real donde está
                $sal.="<td><img src='".$_SERVER['DOCUMENT_ROOT'] . "/musihub/imagenes/fotos/" . $instrumento->getimagen()."'  style='max-width: 12mm; max-height: 12mm'></td>";
                $sal.="</tr>";
            }
            $sal.="</tbody>";
            $sal.="</table>";
        } else {
            $sal.="<p class='lead'><em>No se ha encontrado datos de Instrumentos.</em></p>";
        }
        $pdf=new HTML2PDF('L','A4','es','true','UTF-8');
        $pdf->writeHTML($sal);
        $pdf->output('Instrumentos.pdf');

    }
//-------------------------------------------------------------------------------------------------------------
// Con esta funcion descargaremos en PDF en la parte de administracion
    public function descargarPDFUsu(){
        $sal ='<h2 class="pull-left">Fichas de Usuarios</h2>';
        
        $lista = $controlador = ControladorUsuario::getControlador();
        $lista = $controlador->listarUsuarios("", "");
        
        if (!is_null($lista) && count($lista) > 0) {
            $sal.="<table class='table table-bordered table-striped'>";
            $sal.="<thead>";
            $sal.="<tr>";
            $sal.="<th>Nombre</th>";
            $sal.="<th>Apellidos</th>";
            $sal.="<th>Email</th>";
            $sal.="<th>Contraseña</th>";
            $sal.="<th>Administrador</th>";
            $sal.="<th>Telefono</th>";
            $sal.="<th>Fecha de Alta</th>";
            $sal.="<th>Foto</th>";
            $sal.="</tr>";
            $sal.="</thead>";
            $sal.="<tbody>";
        

            foreach ($lista as $usuario) {
                $sal.="<tr>";
                $sal.="<td>" . $usuario->getnombre() . "</td>";
                $sal.="<td>" . $usuario->getapellidos() . "</td>";
                $sal.="<td>" . $usuario->getemail() . "</td>";
                $sal.="<td>" . str_repeat("*",strlen($usuario->getpassword())) . "</td>";
                $sal.="<td>" . $usuario->getadministrador() . "</td>";
                $sal.="<td>" . $usuario->gettelefono() . "</td>";
                $sal.="<td>" . $usuario->getfecha_alta() . "</td>";
                // Para sacar una imagen hay que decirle el directorio real donde está
                $sal.="<td><img src='".$_SERVER['DOCUMENT_ROOT'] . "/musihub/imagenes/fotos/" . $usuario->getfoto()."'  style='max-width: 12mm; max-height: 12mm'></td>";
                $sal.="</tr>";
            }
            $sal.="</tbody>";
            $sal.="</table>";
        } else {
            $sal.="<p class='lead'><em>No se ha encontrado datos de Usuarios.</em></p>";
        }
        $pdf=new HTML2PDF('L','A4','es','true','UTF-8');
        $pdf->writeHTML($sal);
        $pdf->output('Usuarios.pdf');

    }

//-------------------------------------------------------------------------------------------------------------
// Con esta funcion descargaremos el PDF de la factura final del carrito de compra una vez procesado el pago
    public function descargarfactura($id)
    {
        $cv = ControladorVenta::getControlador();


        $sal = "<h2>Factura</h2>";
        $sal .= "<h3>Pedido nº:" . $_SESSION['venta']['idventa'] . "</h3>";
        $fech = new DateTime($_SESSION['venta']['fecha']);
        $sal .= "<h4>Fecha de compra:" . $fech->format('d/m/Y') . "</h4>";
        $sal .= "<h4>Datos de pago:</h4>";
        $sal .= "<h5>Facturado a: " . $_SESSION['nombre'] . "</h5>";
        $sal .= "<h5>Metodo de pago: Tarjeta de crédito/debito: **** " . $_SESSION['venta']['tarjetapago'] . "</h5>";
        $sal .= "<h4>Datos de Envío:</h4>";
        $sal .= "<h5>Nombre: " . $_SESSION['venta']['nombre'] . "</h5>";
        $sal .= "<h5>Email " . $_SESSION['venta']['email'] . "</h5>";
        $sal .= "<h5>Dirección " . $_SESSION['venta']['direccion'] . "</h5>";
        $sal .= "<h4>Productos</h4>";
        $sal .= "<table>
                <thead>
                       <tr><td><b>Item</b></td><td><b>Precio (PVP)</b></td><td><b>Cantidad</b></td><td><b>Total</b></td>
                        </tr>
                        </thead>
                        <tbody>";
        $arreglo=$_SESSION['carrito']['final'];
        foreach ($arreglo as $key => $fila) {
            $sal .= "<tr>";
            $sal .= "<td>" . $fila['nomProducto'] . " " . $fila['marca'] . "</td>";
            $sal .= "<td>" . $fila['precio'] . " €</td>";
            $sal .= "<td>" . $fila['cantidad'] . "</td>";
            $sal .= "<td>" . ($fila['precio']*$fila['cantidad']) . " €</td>";
            $sal .= "</tr>";
        }
        $final=$_SESSION['precio'];
        $sub=$final/1.21;
        //calculo del precio con iva
        $iva=$final-($final/1.21);
        $sal .= "<tr>
                            <td></td>
                            <td></td>
                            <td><strong>Total sin IVA</strong></td>
                            <td>" . round($sub,2) . "€</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><strong>I.V.A</strong></td>
                            <td>" . round($iva,2) . " €</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><strong>TOTAL</strong></td>
                            <td><strong>" . $final . " €</strong></td>
                        </tr>";


        $sal .= " </tbody>
                    </table>";


        $pdf = new HTML2PDF('P', 'A4', 'es', 'true', 'UTF-8');
        $pdf->writeHTML($sal);
        $pdf->output('factura.pdf');

    }
}

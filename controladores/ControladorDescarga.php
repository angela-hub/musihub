<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/musihub/dirs.php";
require_once CONTROLLER_PATH . "ControladorInstrumento.php";
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
public function descargarTXT()
{
    $this->fichero = "Instrumentos.txt";
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . $this->fichero . "");

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
//---------------------------------------------------------------------------------------------------------

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
    public function descargarXML()
    {
        $this->fichero = "Instrumentos.xml";
        $lista = $controlador = ControladorInstrumento::getControlador();
        $lista = $controlador->listarInstrumento("", "");
        $doc = new DOMDocument('1.0', 'UTF-8');
        $instrumentos = $doc->createElement('instrumento');

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

        $doc->appendChild($instrumento);
        header('Content-type: application/xml');
        //header("Content-Disposition: attachment; filename=" . $nombre . ""); //archivo de salida
        echo $doc->saveXML();

        exit;
    }
//-------------------------------------------------------------------------------------------------------------
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
            $sal.="<th>Accion</th>";
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
}

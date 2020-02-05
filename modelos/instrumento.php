<?php
// declaramos la clase instrumento con sus caracteristicas
class instrumento {
    private $id;
    private $nombre;
    private $referencia;
    private $distribuidor;
    private $tipo;
    private $precio;
    private $descuento;
    private $stockinicial;
    private $imagen;

    
    // Constructor de caracteristicas declaradas en la clase
    public function __construct($id, $nombre, $referencia, $distribuidor, $tipo, $precio, $descuento, $stockinicial, $imagen) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->referencia = $referencia;
        $this->distribuidor = $distribuidor;
        $this->tipo = $tipo;
        $this->precio = $precio;
        $this->descuento = $descuento;
        $this->stockinicial = $stockinicial;
        $this->imagen = $imagen;
    }
    
    //GETS obtener la informacion de las caracteristicas
    function getid() {
        return $this->id;
    }

    function getnombre() {
        return $this->nombre;
    }

    
    function getreferencia() {
        return $this->referencia;
    }

    function getdistribuidor() {
        return $this->distribuidor;
    }

    function gettipo() {
        return $this->tipo;
    }

    function getprecio() {
        return $this->precio;
    }

    function getdescuento() {
        return $this->descuento;
    }

    function getstockinicial() {
        return $this->stockinicial;
    }

    function getimagen() {
        return $this->imagen;
    }

    //SETS ofrece la informacion recogida por los GETS

    function setid($id) {
        $this->id = $id;
    }

    function setnombre($nombre) {
        $this->nombre = $nombre;
    }

    function setreferencia($referencia) {
        $this->referencia = $referencia;
    }
    
    function setcompañia_distribuidor($compañia_distribuidor) {
        $this->compañia_distribuidor = $compañia_distribuidor;
    } 

    function settipo($tipo) {
        $this->tipo = $tipo;
    } 

    function setprecio($precio) {
        $this->precio = $precio;
    } 

    function setdescuento($descuento) {
        $this->descuento = $descuento;
    }
    
    function setstock_inicial($stock_inicial) {
        $this->stock_inicial = $stock_inicial;
    }

    function setimagen($imagen) {
        $this->imagen = $imagen;
    } 
}
?>
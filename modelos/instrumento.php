<?php
class instrumento {
    private $id;
    private $nombre;
    private $referencia;
    private $compañiadistribuidor;
    private $tipo;
    private $precio;
    private $descuento;
    private $stockinicial;
    private $imagen;

    
    // Constructor
    public function __construct($id, $nombre, $referencia, $compañiadistribuidor, $tipo, $precio, $descuento, $stockinicial, $imagen) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->referencia = $referencia;
        $this->compañiadistribuidor = $compañiadistribuidor;
        $this->tipo = $tipo;
        $this->precio = $precio;
        $this->descuento = $descuento;
        $this->stockinicial = $stockinicial;
        $this->imagen = $imagen;
    }
    
    //GETS
    function getid() {
        return $this->id;
    }

    function getnombre() {
        return $this->nombre;
    }

    
    function getreferencia() {
        return $this->referencia;
    }

    function getcompañiadistribuidor() {
        return $this->compañiadistribuidor;
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

    //SETS

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
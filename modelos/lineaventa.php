<?php

// declaramos la clase lineaventa con sus caracteristicas
class lineaventa {

    private $idventa;
    private $idproducto;
    private $distribuidor;
    private $tipo;
    private $precio;
    private $cantidad;

    // Constructor de caracteristicas declaradas en la clase
    
    public function __construct($idventa, $idproducto, $distribuidor, $tipo, $precio, $cantidad)
    {
        $this->idventa = $idventa;
        $this->idproducto = $idproducto;
        $this->distribuidor = $distribuidor;
        $this->tipo = $tipo;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
    }
//GETS obtiene la informacion de las caracteristicas y SET nos la ofreve

    
    public function getidventa()
    {
        return $this->idventa;
    }

    public function getidproducto()
    {
        return $this->idproducto;
    }
 
    public function getdistribuidor()
    {
        return $this->distribuidor;
    }

    public function gettipo()
    {
        return $this->tipo;
    }

    public function getprecio()
    {
        return $this->precio;
    }

    public function getcantidad()
    {
        return $this->cantidad;
    }


    //SETS ofrece la informacion recogida por los GETS

    
    public function setidventa($idventa): void
    {
        $this->idventa = $idventa;
    }


    public function setidproducto($idproducto): void
    {
        $this->idproducto = $idproducto;
    }

    public function setdistribuidor($distribuidor): void
    {
        $this->distribuidor = $distribuidor;
    }

    public function settipo($tipo): void
    {
        $this->tipo = $tipo;
    }
    

    public function setprecio($precio): void
    {
        $this->precio = $precio;
    }
   
    public function setcantidad($cantidad): void
    {
        $this->cantidad = $cantidad;
    }




}
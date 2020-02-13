<?php

// declaramos la clase lineaventa con sus caracteristicas
class pago {

    private $idpago;
    private $titular;
    private $tarjeta_completa;
    private $fecha;
    private $cv;

    // Constructor de caracteristicas declaradas en la clase
    
    public function __construct($idpago, $titular, $tarjeta_completa, $fecha, $cv)
    {
        $this->idpago = $idpago;
        $this->titular = $titular;
        $this->tarjeta_completa = $tarjeta_completa;
        $this->fecha = $fecha;
        $this->cv = $cv;
    }
//GETS obtiene la informacion de las caracteristicas y SET nos la ofreve

    
    public function getidpago()
    {
        return $this->idpago;
    }

    public function gettitular()
    {
        return $this->titular;
    }
 
    public function gettarjeta_completa()
    {
        return $this->tarjeta_completa;
    }

    public function getfecha()
    {
        return $this->fecha;
    }

    public function getcv()
    {
        return $this->cv;
    }

    //SETS Asigna a cada caracteristica del instrumento un valor el cual se asignara llamando a la funcion y pasandole el parametro

    
    public function setidpago($idpago): void
    {
        $this->idpago = $idpago;
    }


    public function settitular($titular): void
    {
        $this->titular = $titular;
    }

    public function settarjeta_completa($tarjeta_completa): void
    {
        $this->tarjeta_completa = $tarjeta_completa;
    }

    public function setfecha($fecha): void
    {
        $this->fecha = $fecha;
    }
    

    public function setcv($cv): void
    {
        $this->cv = $cv;
    }
}
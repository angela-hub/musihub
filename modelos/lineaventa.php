<?php


class lineaventa {

    private $idventa;
    private $idproducto;
    private $distribuidor;
    private $tipo;
    private $precio;
    private $cantidad;

    /**
     * LineaVenta constructor.
     * @param $idventa
     * @param $idproducto
     * @param $distribuidor
     * @param $tipo
     * @param $precio
     * @param $cantidad
     */
    public function __construct($idventa, $idproducto, $distribuidor, $tipo, $precio, $cantidad)
    {
        $this->idventa = $idventa;
        $this->idproducto = $idproducto;
        $this->distribuidor = $distribuidor;
        $this->tipo = $tipo;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
    }

    /**
     * @return mixed
     */
    public function getidventa()
    {
        return $this->idventa;
    }

    /**
     * @param mixed $idventa
     */
    public function setidventa($idventa): void
    {
        $this->idventa = $idventa;
    }

    /**
     * @return mixed
     */
    public function getidproducto()
    {
        return $this->idproducto;
    }

    /**
     * @param mixed $idproducto
     */
    public function setidproducto($idproducto): void
    {
        $this->idproducto = $idproducto;
    }

    /**
     * @return mixed
     */
    public function getdistribuidor()
    {
        return $this->distribuidor;
    }

    /**
     * @param mixed $distribuidor
     */
    public function setdistribuidor($distribuidor): void
    {
        $this->distribuidor = $distribuidor;
    }

    /**
     * @return mixed
     */
    public function gettipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function settipo($tipo): void
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getprecio()
    {
        return $this->precio;
    }

    /**
     * @param mixed $precio
     */
    public function setprecio($precio): void
    {
        $this->precio = $precio;
    }

    /**
     * @return mixed
     */
    public function getcantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setcantidad($cantidad): void
    {
        $this->cantidad = $cantidad;
    }




}
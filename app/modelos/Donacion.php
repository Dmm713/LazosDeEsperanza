<?php 

class Donacion {
    private $idDonacion;
    private $idUsuario;
    private $idProyecto;
    private $cantidad;
    private $fecha;
    private $numeroTarjeta;
    private $mes;
    private $year;
    private $ccv;

    public function __construct($idUsuario = null, $idProyecto = null, $cantidad = null) {
        $this->idUsuario = $idUsuario;
        $this->idProyecto = $idProyecto;
        $this->cantidad = $cantidad;
        $this->fecha = date('Y-m-d');
    }

    /**
     * Get the value of fecha
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     */
    public function setFecha($fecha): self {
        $this->fecha = $fecha;
        return $this;
    }

    /**
     * Get the value of cantidad
     */
    public function getCantidad() {
        return $this->cantidad;
    }

    /**
     * Set the value of cantidad
     */
    public function setCantidad($cantidad): self {
        $this->cantidad = $cantidad;
        return $this;
    }

    /**
     * Get the value of idProyecto
     */
    public function getIdProyecto() {
        return $this->idProyecto;
    }

    /**
     * Set the value of idProyecto
     */
    public function setIdProyecto($idProyecto): self {
        $this->idProyecto = $idProyecto;
        return $this;
    }

    /**
     * Get the value of idUsuario
     */
    public function getIdUsuario() {
        return $this->idUsuario;
    }

    /**
     * Set the value of idUsuario
     */
    public function setIdUsuario($idUsuario): self {
        $this->idUsuario = $idUsuario;
        return $this;
    }

    /**
     * Get the value of idDonacion
     */
    public function getIdDonacion() {
        return $this->idDonacion;
    }

    /**
     * Set the value of idDonacion
     */
    public function setIdDonacion($idDonacion): self {
        $this->idDonacion = $idDonacion;
        return $this;
    }

    /**
     * Get the value of numeroTarjeta
     */
    public function getNumeroTarjeta() {
        return $this->numeroTarjeta;
    }

    /**
     * Set the value of numeroTarjeta
     */
    public function setNumeroTarjeta($numeroTarjeta): self {
        $this->numeroTarjeta = $numeroTarjeta;
        return $this;
    }

    /**
     * Get the value of mes
     */
    public function getMes() {
        return $this->mes;
    }

    /**
     * Set the value of mes
     */
    public function setMes($mes): self {
        $this->mes = $mes;
        return $this;
    }

    /**
     * Get the value of year
     */
    public function getYear() {
        return $this->year;
    }

    /**
     * Set the value of year
     */
    public function setYear($year): self {
        $this->year = $year;
        return $this;
    }

    /**
     * Get the value of ccv
     */
    public function getCcv() {
        return $this->ccv;
    }

    /**
     * Set the value of ccv
     */
    public function setCcv($ccv): self {
        $this->ccv = $ccv;
        return $this;
    }
}
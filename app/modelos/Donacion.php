<?php 

class Usuario {
    private $idDonacion;
    private $idUsuario;
    private $idProyecto;
    private $cantidad;
    private $fecha;
    private $metodoDePago;

    /**
     * Get the value of metodoDePago
     */
    public function getMetodoDePago() {
        return $this->metodoDePago;
    }

    /**
     * Set the value of metodoDePago
     */
    public function setMetodoDePago($metodoDePago): self {
        $this->metodoDePago = $metodoDePago;
        return $this;
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
}
<?php 

class Evento {
    private $idEvento;
    private $idOrganizacion;
    private $titulo;
    private $descripcion;
    private $fechaEvento;
    private $ubicacion;

    /**
     * Get the value of idEvento
     */
    public function getIdEvento() {
        return $this->idEvento;
    }

    /**
     * Set the value of idEvento
     */
    public function setIdEvento($idEvento): self {
        $this->idEvento = $idEvento;
        return $this;
    }

    /**
     * Get the value of idOrganizacion
     */
    public function getIdOrganizacion() {
        return $this->idOrganizacion;
    }

    /**
     * Set the value of idOrganizacion
     */
    public function setIdOrganizacion($idOrganizacion): self {
        $this->idOrganizacion = $idOrganizacion;
        return $this;
    }

    /**
     * Get the value of titulo
     */
    public function getTitulo() {
        return $this->titulo;
    }

    /**
     * Set the value of titulo
     */
    public function setTitulo($titulo): self {
        $this->titulo = $titulo;
        return $this;
    }

    /**
     * Get the value of descripcion
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     */
    public function setDescripcion($descripcion): self {
        $this->descripcion = $descripcion;
        return $this;
    }

    /**
     * Get the value of fechaEvento
     */
    public function getFechaEvento() {
        return $this->fechaEvento;
    }

    /**
     * Set the value of fechaEvento
     */
    public function setFechaEvento($fechaEvento): self {
        $this->fechaEvento = $fechaEvento;
        return $this;
    }

    /**
     * Get the value of ubicacion
     */
    public function getUbicacion() {
        return $this->ubicacion;
    }

    /**
     * Set the value of ubicacion
     */
    public function setUbicacion($ubicacion): self {
        $this->ubicacion = $ubicacion;
        return $this;
    }
}
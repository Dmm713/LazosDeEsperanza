<?php 

class Proyecto {
    private $idProyecto;
    private $idOrganizacion;
    private $titulo;
    private $descripcion;
    private $fechaInicio;
    private $fechaFin;
    private $objetivoFinanciero;
    private $fotoProyecto;

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
     * Get the value of idOrganización
     */
    public function getIdOrganizacion() {
        return $this->idOrganizacion;
    }

    /**
     * Set the value of idOrganización
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
     * Get the value of fechaInicio
     */
    public function getFechaInicio() {
        return $this->fechaInicio;
    }

    /**
     * Set the value of fechaInicio
     */
    public function setFechaInicio($fechaInicio): self {
        $this->fechaInicio = $fechaInicio;
        return $this;
    }

    /**
     * Get the value of fechaFin
     */
    public function getFechaFin() {
        return $this->fechaFin;
    }

    /**
     * Set the value of fechaFin
     */
    public function setFechaFin($fechaFin): self {
        $this->fechaFin = $fechaFin;
        return $this;
    }

    /**
     * Get the value of objetivoFinanciero
     */
    public function getObjetivoFinanciero() {
        return $this->objetivoFinanciero;
    }

    /**
     * Set the value of objetivoFinanciero
     */
    public function setObjetivoFinanciero($objetivoFinanciero): self {
        $this->objetivoFinanciero = $objetivoFinanciero;
        return $this;
    }

    /**
     * Get the value of fotoProyecto
     */
    public function getFotoProyecto() {
        return $this->fotoProyecto;
    }

    /**
     * Set the value of fotoProyecto
     */
    public function setFotoProyecto($fotoProyecto): self {
        $this->fotoProyecto = $fotoProyecto;
        return $this;
    }
}
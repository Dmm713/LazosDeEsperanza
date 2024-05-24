<?php 

class Usuario {
    private $idVoluntario;
    private $idProyecto;
    private $idUsuario;
    private $fechaInicio;
    private $fechaFin;

    /**
     * Get the value of idVoluntario
     */
    public function getIdVoluntario() {
        return $this->idVoluntario;
    }

    /**
     * Set the value of idVoluntario
     */
    public function setIdVoluntario($idVoluntario): self {
        $this->idVoluntario = $idVoluntario;
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
}
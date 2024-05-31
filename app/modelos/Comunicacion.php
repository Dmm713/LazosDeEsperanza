<?php 

class Comunicacion {
    private $idComunicacion;
    private $idUsuarioEmisor;
    private $idUsuarioReceptor;
    private $mensaje;
    private $fechaHora;

    /**
     * Get the value of idComunicacion
     */
    public function getIdComunicacion() {
        return $this->idComunicacion;
    }

    /**
     * Set the value of idComunicacion
     */
    public function setIdComunicacion($idComunicacion): self {
        $this->idComunicacion = $idComunicacion;
        return $this;
    }

    /**
     * Get the value of idUsuarioEmisor
     */
    public function getIdUsuarioEmisor() {
        return $this->idUsuarioEmisor;
    }

    /**
     * Set the value of idUsuarioEmisor
     */
    public function setIdUsuarioEmisor($idUsuarioEmisor): self {
        $this->idUsuarioEmisor = $idUsuarioEmisor;
        return $this;
    }

    /**
     * Get the value of idUsuarioReceptor
     */
    public function getIdUsuarioReceptor() {
        return $this->idUsuarioReceptor;
    }

    /**
     * Set the value of idUsuarioReceptor
     */
    public function setIdUsuarioReceptor($idUsuarioReceptor): self {
        $this->idUsuarioReceptor = $idUsuarioReceptor;
        return $this;
    }

    /**
     * Get the value of mensaje
     */
    public function getMensaje() {
        return $this->mensaje;
    }

    /**
     * Set the value of mensaje
     */
    public function setMensaje($mensaje): self {
        $this->mensaje = $mensaje;
        return $this;
    }

    /**
     * Get the value of fechaHora
     */
    public function getFechaHora() {
        return $this->fechaHora;
    }

    /**
     * Set the value of fechaHora
     */
    public function setFechaHora($fechaHora): self {
        $this->fechaHora = $fechaHora;
        return $this;
    }
}
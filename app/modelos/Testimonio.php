<?php 

class Testimonio {
    private $idTestimonio;
    private $idOrganizacion;
    private $nombre;
    private $apellidos;
    private $problema;
    private $solucion;
    private $foto;



    /**
     * Get the value of idTestimonio
     */
    public function getIdTestimonio() {
        return $this->idTestimonio;
    }

    /**
     * Set the value of idTestimonio
     */
    public function setIdTestimonio($idTestimonio): self {
        $this->idTestimonio = $idTestimonio;
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
     * Get the value of nombre
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre($nombre): self {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * Get the value of apellidos
     */
    public function getApellidos() {
        return $this->apellidos;
    }

    /**
     * Set the value of apellidos
     */
    public function setApellidos($apellidos): self {
        $this->apellidos = $apellidos;
        return $this;
    }

    /**
     * Get the value of problema
     */
    public function getProblema() {
        return $this->problema;
    }

    /**
     * Set the value of problema
     */
    public function setProblema($problema): self {
        $this->problema = $problema;
        return $this;
    }

    /**
     * Get the value of solucion
     */
    public function getSolucion() {
        return $this->solucion;
    }

    /**
     * Set the value of solucion
     */
    public function setSolucion($solucion): self {
        $this->solucion = $solucion;
        return $this;
    }

    /**
     * Get the value of foto
     */
    public function getFoto() {
        return $this->foto;
    }

    /**
     * Set the value of foto
     */
    public function setFoto($foto): self {
        $this->foto = $foto;
        return $this;
    }
}
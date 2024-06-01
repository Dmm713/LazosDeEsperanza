<?php 

class Organizacion {
    private $idOrganizacion;
    private $nombre;
    private $descripcion;
    private $sitioWeb;
    private $telefono;
    private $email;
    private $password;
    private $direccion;
    private $foto;
    private $ciego;
    private $rol;
    private $sid;

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
     * Get the value of sitioWeb
     */
    public function getSitioWeb() {
        return $this->sitioWeb;
    }

    /**
     * Set the value of sitioWeb
     */
    public function setSitioWeb($sitioWeb): self {
        $this->sitioWeb = $sitioWeb;
        return $this;
    }

    /**
     * Get the value of telefono
     */
    public function getTelefono() {
        return $this->telefono;
    }

    /**
     * Set the value of telefono
     */
    public function setTelefono($telefono): self {
        $this->telefono = $telefono;
        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail($email): self {
        $this->email = $email;
        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword($password): self {
        $this->password = $password;
        return $this;
    }

    /**
     * Get the value of direccion
     */
    public function getDireccion() {
        return $this->direccion;
    }

    /**
     * Set the value of direccion
     */
    public function setDireccion($direccion): self {
        $this->direccion = $direccion;
        return $this;
    }

    /**
     * Get the value of sid
     */
    public function getSid() {
        return $this->sid;
    }

    /**
     * Set the value of sid
     */
    public function setSid($sid): self {
        $this->sid = $sid;
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

    /**
     * Get the value of rol
     */
    public function getRol() {
        return $this->rol;
    }

    /**
     * Set the value of rol
     */
    public function setRol($rol): self {
        $this->rol = $rol;
        return $this;
    }

    /**
     * Get the value of ciego
     */
    public function getCiego() {
        return $this->ciego;
    }

    /**
     * Set the value of ciego
     */
    public function setCiego($ciego): self {
        $this->ciego = $ciego;
        return $this;
    }
}
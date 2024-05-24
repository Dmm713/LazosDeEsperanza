<?php 

class Usuario {
    private $idUsuario;
    private $nombre;
    private $apellidos;
    private $direccion;
    private $ciego;
    private $email;
    private $password;
    private $rol;
    private $foto;
    private $sid;


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
}
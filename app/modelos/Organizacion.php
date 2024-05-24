<?php 

class Usuario {
    private $idOrganización;
    private $idUsuario;
    private $nombre;
    private $descripcion;
    private $sitioWeb;
    private $telefono;
    private $email;
    private $password;
    private $direccion;

    /**
     * Get the value of idOrganización
     */
    public function getIdOrganización() {
        return $this->idOrganización;
    }

    /**
     * Set the value of idOrganización
     */
    public function setIdOrganización($idOrganización): self {
        $this->idOrganización = $idOrganización;
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
}
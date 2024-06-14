<?php

class TestimoniosDAO {

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getTestimoniosByOrganizacion($idOrganizacion){
        $query = "SELECT * FROM testimonios WHERE idOrganizacion = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $idOrganizacion);
        $stmt->execute();
        $result = $stmt->get_result();
        $testimoniosData = $result->fetch_all(MYSQLI_ASSOC);
    
        $testimonios = [];
        foreach ($testimoniosData as $testimonioData) {
            $testimonio = new Testimonio();
            $testimonio->setIdTestimonio($testimonioData['idTestimonio']);
            $testimonio->setIdOrganizacion($testimonioData['idOrganizacion']);
            $testimonio->setNombre($testimonioData['nombre']);
            $testimonio->setApellidos($testimonioData['apellidos']);
            $testimonio->setProblema($testimonioData['problema']);
            $testimonio->setSolucion($testimonioData['solucion']);
            $testimonio->setFoto($testimonioData['foto']);
            $testimonios[] = $testimonio;
        }
    
        return $testimonios;
    }
    
    public function insertTestimonio(Testimonio $testimonio)
    {
        $query = "INSERT INTO testimonios (idOrganizacion, nombre, apellidos, problema, solucion, foto) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            'isssss',
            $testimonio->getIdOrganizacion(),
            $testimonio->getNombre(),
            $testimonio->getApellidos(),
            $testimonio->getProblema(),
            $testimonio->getSolucion(),
            $testimonio->getFoto()
        );
        return $stmt->execute();
    }
    
    public function updateTestimonio(Testimonio $testimonio)
    {
        $sql = "UPDATE testimonios SET nombre = ?, apellidos = ?, problema = ?, solucion = ?, foto = ? WHERE idTestimonio = ?";
        $stmt = $this->conn->prepare($sql);
        
        $nombre = $testimonio->getNombre();
        $apellidos = $testimonio->getApellidos();
        $problema = $testimonio->getProblema();
        $solucion = $testimonio->getSolucion();
        $foto = $testimonio->getFoto();
        $idTestimonio = $testimonio->getIdTestimonio();
        
        $stmt->bind_param("sssssi", $nombre, $apellidos, $problema, $solucion, $foto, $idTestimonio);
        
        return $stmt->execute();
    }
    
    public function deleteTestimonio($idTestimonio)
    {
        $query = "SELECT foto FROM testimonios WHERE idTestimonio = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $idTestimonio);
        $stmt->execute();
        $result = $stmt->get_result();
        $testimonioData = $result->fetch_assoc();
        $foto = $testimonioData['foto'];
    
        // Ahora, eliminar el testimonio
        $query = "DELETE FROM testimonios WHERE idTestimonio = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $idTestimonio);
        $success = $stmt->execute();
    
        return $success ? $foto : null;
    }
    
    public function getTestimonioById($idTestimonio)
    {
        $query = "SELECT * FROM testimonios WHERE idTestimonio = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $idTestimonio);
        $stmt->execute();
        $result = $stmt->get_result();
        $testimonioData = $result->fetch_assoc();
    
        if ($testimonioData) {
            $testimonio = new Testimonio();
            $testimonio->setIdTestimonio($testimonioData['idTestimonio']);
            $testimonio->setIdOrganizacion($testimonioData['idOrganizacion']);
            $testimonio->setNombre($testimonioData['nombre']);
            $testimonio->setApellidos($testimonioData['apellidos']);
            $testimonio->setProblema($testimonioData['problema']);
            $testimonio->setSolucion($testimonioData['solucion']);
            $testimonio->setFoto($testimonioData['foto']);
            return $testimonio;
        }
    
        return null;
    }
    
    public function getAllTestimonios() {
        $query = "SELECT * FROM testimonios";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $testimoniosData = $result->fetch_all(MYSQLI_ASSOC);
    
        $testimonios = [];
        foreach ($testimoniosData as $testimonioData) {
            $testimonio = new Testimonio();
            $testimonio->setIdTestimonio($testimonioData['idTestimonio']);
            $testimonio->setIdOrganizacion($testimonioData['idOrganizacion']);
            $testimonio->setNombre($testimonioData['nombre']);
            $testimonio->setApellidos($testimonioData['apellidos']);
            $testimonio->setProblema($testimonioData['problema']);
            $testimonio->setSolucion($testimonioData['solucion']);
            $testimonio->setFoto($testimonioData['foto']);
            $testimonios[] = $testimonio;
        }
    
        return $testimonios;
    }
    
}
<?php

class ProyectosDAO {
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getProyectosByOrganizacion($idOrganizacion){
        $query = "SELECT * FROM proyectos WHERE idOrganizacion = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $idOrganizacion);
        $stmt->execute();
        $result = $stmt->get_result();
        $proyectosData = $result->fetch_all(MYSQLI_ASSOC);

        $proyectos = [];
        foreach ($proyectosData as $proyectoData) {
            $proyecto = new Proyecto();
            $proyecto->setIdProyecto($proyectoData['idProyecto']);
            $proyecto->setIdOrganizacion($proyectoData['idOrganizacion']);
            $proyecto->setTitulo($proyectoData['titulo']);
            $proyecto->setDescripcion($proyectoData['descripcion']);
            $proyecto->setFechaInicio($proyectoData['fechaInicio']);
            $proyecto->setFechaFin($proyectoData['fechaFin']);
            $proyecto->setObjetivoFinanciero($proyectoData['objetivoFinanciero']);
            $proyecto->setFotoProyecto($proyectoData['fotoProyecto']);
            $proyectos[] = $proyecto;
        }

        return $proyectos;
    }

    public function insert(Proyecto $proyecto)
{
    $query = "INSERT INTO proyectos (idOrganizacion, titulo, descripcion, fechaInicio, fechaFin, objetivoFinanciero, fotoProyecto) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param(
        'issssds',
        $proyecto->getIdOrganizacion(),
        $proyecto->getTitulo(),
        $proyecto->getDescripcion(),
        $proyecto->getFechaInicio(),
        $proyecto->getFechaFin(),
        $proyecto->getObjetivoFinanciero(),
        $proyecto->getFotoProyecto()
    );
    return $stmt->execute();
}

public function update($proyecto) {
    $sql = "UPDATE proyectos SET titulo = ?, descripcion = ?, fechaInicio = ?, fechaFin = ?, objetivoFinanciero = ?, fotoProyecto = ? WHERE idProyecto = ?";
    $stmt = $this->conn->prepare($sql);
    
    $titulo = $proyecto->getTitulo();
    $descripcion = $proyecto->getDescripcion();
    $fechaInicio = $proyecto->getFechaInicio();
    $fechaFin = $proyecto->getFechaFin();
    $objetivoFinanciero = $proyecto->getObjetivoFinanciero();
    $fotoProyecto = $proyecto->getFotoProyecto();
    $idProyecto = $proyecto->getIdProyecto();
    
    $stmt->bind_param("ssssssi", $titulo, $descripcion, $fechaInicio, $fechaFin, $objetivoFinanciero, $fotoProyecto, $idProyecto);
    
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}


public function delete($idProyecto)
{
    $query = "SELECT fotoProyecto FROM proyectos WHERE idProyecto = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('i', $idProyecto);
    $stmt->execute();
    $result = $stmt->get_result();
    $proyectoData = $result->fetch_assoc();
    $fotoProyecto = $proyectoData['fotoProyecto'];

    // Ahora, eliminar el proyecto
    $query = "DELETE FROM proyectos WHERE idProyecto = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('i', $idProyecto);
    $success = $stmt->execute();

    return $success ? $fotoProyecto : null;
}

public function getById($idProyecto)
{
    $query = "SELECT * FROM proyectos WHERE idProyecto = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('i', $idProyecto);
    $stmt->execute();
    $result = $stmt->get_result();
    $proyectoData = $result->fetch_assoc();

    if ($proyectoData) {
        $proyecto = new Proyecto();
        $proyecto->setIdProyecto($proyectoData['idProyecto']);
        $proyecto->setIdOrganizacion($proyectoData['idOrganizacion']);
        $proyecto->setTitulo($proyectoData['titulo']);
        $proyecto->setDescripcion($proyectoData['descripcion']);
        $proyecto->setFechaInicio($proyectoData['fechaInicio']);
        $proyecto->setFechaFin($proyectoData['fechaFin']);
        $proyecto->setObjetivoFinanciero($proyectoData['objetivoFinanciero']);
        $proyecto->setFotoProyecto($proyectoData['fotoProyecto']);
        return $proyecto;
    }

    return null;
}

}
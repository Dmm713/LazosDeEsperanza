<?php

class VoluntariosDAO {
    private mysqli $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getByIdVoluntario($idVoluntario): ?Voluntario {
        if(!$stmt = $this->conn->prepare("SELECT * FROM voluntarios WHERE idVoluntario = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
            return null;
        }
        $stmt->bind_param('i', $idVoluntario);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows >= 1) {
            $voluntario = $result->fetch_object(Voluntario::class);
            return $voluntario;
        } else {
            return null;
        }
    } 

    public function getByIdProyecto($idProyecto): array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM voluntarios WHERE idProyecto = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
            return [];
        }
        $stmt->bind_param('i', $idProyecto);
        $stmt->execute();
        $result = $stmt->get_result();
        $array_voluntarios = array();
        while($voluntario = $result->fetch_object(Voluntario::class)) {
            $array_voluntarios[] = $voluntario;
        }
        return $array_voluntarios;
    }

    public function getByIdUsuario($idUsuario): array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM voluntarios WHERE idUsuario = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
            return [];
        }
        $stmt->bind_param('i', $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $array_voluntarios = array();
        while($voluntario = $result->fetch_object(Voluntario::class)) {
            $array_voluntarios[] = $voluntario;
        }
        return $array_voluntarios;
    }

    public function getAllVoluntarios(): array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM voluntarios")) {
            echo "Error en la SQL: " . $this->conn->error;
            return [];
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $array_voluntarios = array();
        while($voluntario = $result->fetch_object(Voluntario::class)) {
            $array_voluntarios[] = $voluntario;
        }
        return $array_voluntarios;
    }

    public function insert(Voluntario $voluntario): int|bool {
        if(!$stmt = $this->conn->prepare("INSERT INTO voluntarios (idProyecto, idUsuario, fechaInicio, fechaFin) VALUES (?,?,?,?)")) {
            die("Error al preparar la consulta insert: " . $this->conn->error );
        }
        $idProyecto = $voluntario->getIdProyecto();
        $idUsuario = $voluntario->getIdUsuario();
        $fechaInicio = $voluntario->getFechaInicio();
        $fechaFin = $voluntario->getFechaFin();
        $stmt->bind_param('iiss', $idProyecto, $idUsuario, $fechaInicio, $fechaFin);
        if($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    public function borrarVoluntario($idVoluntario): bool {
        if(!$stmt = $this->conn->prepare("DELETE FROM voluntarios WHERE idVoluntario = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
            return false;
        }
        $stmt->bind_param('i', $idVoluntario);
        $stmt->execute();
        return $stmt->affected_rows == 1;
    }

    public function update(Voluntario $voluntario): bool {
        if(!$stmt = $this->conn->prepare("UPDATE voluntarios SET idProyecto=?, idUsuario=?, fechaInicio=?, fechaFin=? WHERE idVoluntario=?")) {
            die("Error al preparar la consulta update: " . $this->conn->error );
        }
        $idProyecto = $voluntario->getIdProyecto();
        $idUsuario = $voluntario->getIdUsuario();
        $fechaInicio = $voluntario->getFechaInicio();
        $fechaFin = $voluntario->getFechaFin();
        $idVoluntario = $voluntario->getIdVoluntario();
        $stmt->bind_param('iissi', $idProyecto, $idUsuario, $fechaInicio, $fechaFin, $idVoluntario);
        return $stmt->execute();
    }

    public function getVoluntariadosByUsuario($idUsuario) {
        $query = "SELECT * FROM voluntarios WHERE idUsuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $voluntariados = $result->fetch_all(MYSQLI_ASSOC);
        return $voluntariados;
    }

    public function getVoluntariadosByUsuarioWithProjectDetails($idUsuario) {
        $query = "
            SELECT v.*, p.titulo AS nombreProyecto, p.descripcion AS descripcionProyecto, p.fotoProyecto 
            FROM voluntarios v
            INNER JOIN proyectos p ON v.idProyecto = p.idProyecto
            WHERE v.idUsuario = ?
        ";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            echo "Error en la SQL: " . $this->conn->error;
            return [];
        }
        $stmt->bind_param('i', $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $voluntariados = $result->fetch_all(MYSQLI_ASSOC);
        return $voluntariados;
    }
    
    
}

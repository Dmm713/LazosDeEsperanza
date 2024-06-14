<?php

class EventosDAO
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getEventosByOrganizacion($idOrganizacion){
        $query = "SELECT * FROM eventos WHERE idOrganizacion = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $idOrganizacion);
        $stmt->execute();
        $result = $stmt->get_result();
        $eventosData = $result->fetch_all(MYSQLI_ASSOC);

        $eventos = [];
        foreach ($eventosData as $eventoData) {
            $evento = new Evento();
            $evento->setIdEvento($eventoData['idEvento']);
            $evento->setIdOrganizacion($eventoData['idOrganizacion']);
            $evento->setTitulo($eventoData['titulo']);
            $evento->setDescripcion($eventoData['descripcion']);
            $evento->setFechaEvento($eventoData['fechaEvento']);
            $evento->setUbicacion($eventoData['ubicacion']);
            $evento->setFotoEvento($eventoData['fotoEvento']);
            $eventos[] = $evento;
        }

        return $eventos;
    }

    public function insert(Evento $evento)
    {
        $query = "INSERT INTO eventos (idOrganizacion, titulo, descripcion, fechaEvento, ubicacion, fotoEvento) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            'isssss',
            $evento->getIdOrganizacion(),
            $evento->getTitulo(),
            $evento->getDescripcion(),
            $evento->getFechaEvento(),
            $evento->getUbicacion(),
            $evento->getFotoEvento()
        );
        return $stmt->execute();
    }

    public function update(Evento $evento)
    {
        $query = "UPDATE eventos SET titulo = ?, descripcion = ?, fechaEvento = ?, ubicacion = ?, fotoEvento = ? WHERE idEvento = ? AND idOrganizacion = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            'sssssii',
            $evento->getTitulo(),
            $evento->getDescripcion(),
            $evento->getFechaEvento(),
            $evento->getUbicacion(),
            $evento->getFotoEvento(),
            $evento->getIdEvento(),
            $evento->getIdOrganizacion()
        );
        return $stmt->execute();
    }

    public function delete($idEvento)
    {
        
        $query = "SELECT fotoEvento FROM eventos WHERE idEvento = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $idEvento);
        $stmt->execute();
        $result = $stmt->get_result();
        $eventoData = $result->fetch_assoc();
        $fotoEvento = $eventoData['fotoEvento'];

        // Ahora, eliminar el evento
        $query = "DELETE FROM eventos WHERE idEvento = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $idEvento);
        $success = $stmt->execute();

        return $success ? $fotoEvento : null;
    }

    public function getById($idEvento)
    {
        $query = "SELECT * FROM eventos WHERE idEvento = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $idEvento);
        $stmt->execute();
        $result = $stmt->get_result();
        $eventoData = $result->fetch_assoc();

        if ($eventoData) {
            $evento = new Evento();
            $evento->setIdEvento($eventoData['idEvento']);
            $evento->setIdOrganizacion($eventoData['idOrganizacion']);
            $evento->setTitulo($eventoData['titulo']);
            $evento->setDescripcion($eventoData['descripcion']);
            $evento->setFechaEvento($eventoData['fechaEvento']);
            $evento->setUbicacion($eventoData['ubicacion']);
            $evento->setFotoEvento($eventoData['fotoEvento']);
            return $evento;
        }

        return null;
    }

    public function getAllEventos() {
        $query = "SELECT * FROM eventos";
        $result = $this->conn->query($query);
        $eventosData = $result->fetch_all(MYSQLI_ASSOC);
    
        $eventos = [];
        foreach ($eventosData as $eventoData) {
            $evento = new Evento();
            $evento->setIdEvento($eventoData['idEvento']);
            $evento->setIdOrganizacion($eventoData['idOrganizacion']);
            $evento->setTitulo($eventoData['titulo']);
            $evento->setDescripcion($eventoData['descripcion']);
            $evento->setFechaEvento($eventoData['fechaEvento']);
            $evento->setUbicacion($eventoData['ubicacion']);
            $evento->setFotoEvento($eventoData['fotoEvento']);
            $eventos[] = $evento;
        }
    
        return $eventos;
    }
    

}

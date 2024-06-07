<?php

class EventosDAO {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getEventosByOrganizacion($idOrganizacion) {
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

    public function insert(Evento $evento) {
        $query = "INSERT INTO eventos (idOrganizacion, titulo, descripcion, fechaEvento, ubicacion, fotoEvento) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('isssss', 
            $evento->getIdOrganizacion(),
            $evento->getTitulo(),
            $evento->getDescripcion(),
            $evento->getFechaEvento(),
            $evento->getUbicacion(),
            $evento->getFotoEvento()
        );
        return $stmt->execute();
    }
}

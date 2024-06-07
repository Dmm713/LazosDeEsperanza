<?php

class EventosDAO {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getEventosByOrganizacion($idOrganizacion) {
        $query = "SELECT * FROM eventos WHERE idOrganizacion = :idOrganizacion";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idOrganizacion', $idOrganizacion, PDO::PARAM_INT);
        $stmt->execute();
        $eventosData = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

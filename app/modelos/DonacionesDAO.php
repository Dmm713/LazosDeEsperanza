<?php 
class DonacionesDAO {
    private mysqli $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insert(Donacion $donacion) {
        $query = "INSERT INTO donaciones (idUsuario, idProyecto, cantidad, fecha, numeroTarjeta, mes, year, ccv) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $idUsuario = $donacion->getIdUsuario();
        $idProyecto = $donacion->getIdProyecto();
        $cantidad = $donacion->getCantidad();
        $fecha = $donacion->getFecha();

        $numeroTarjeta = $donacion->getNumeroTarjeta();
        $mes = $donacion->getMes();
        $year = $donacion->getYear();
        $ccv = $donacion->getCcv();

        $stmt->bind_param("iiisssss", $idUsuario, $idProyecto, $cantidad, $fecha, $numeroTarjeta, $mes, $year, $ccv);

        return $stmt->execute();
    }

    public function getDonacionById($idDonacion) {
        $query = "SELECT * FROM donaciones WHERE idDonacion = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idDonacion);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return $this->mapRowToDonacion($row);
        }
        
        return null;
    }

    public function getAllDonaciones() {
        $query = "SELECT * FROM donaciones";
        $result = $this->conn->query($query);
        $donaciones = [];
        
        while ($row = $result->fetch_assoc()) {
            $donaciones[] = $this->mapRowToDonacion($row);
        }

        return $donaciones;
    }

    public function getDonacionesByUsuario($idUsuario) {
        $query = "SELECT * FROM donaciones WHERE idUsuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $donaciones = [];
        
        while ($row = $result->fetch_assoc()) {
            $donaciones[] = $this->mapRowToDonacion($row);
        }

        return $donaciones;
    }

    public function getDonacionesByProyecto($idProyecto) {
        $query = "SELECT * FROM donaciones WHERE idProyecto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idProyecto);
        $stmt->execute();
        $result = $stmt->get_result();
        $donaciones = [];
        
        while ($row = $result->fetch_assoc()) {
            $donaciones[] = $this->mapRowToDonacion($row);
        }

        return $donaciones;
    }

    private function mapRowToDonacion($row) {
        $donacion = new Donacion(
            $row['idUsuario'],
            $row['idProyecto'],
            $row['cantidad']
        );
        $donacion->setIdDonacion($row['idDonacion']);
        $donacion->setFecha($row['fecha']);
        $donacion->setNumeroTarjeta($row['numeroTarjeta']);
        $donacion->setMes($row['mes']);
        $donacion->setYear($row['year']);
        $donacion->setCcv($row['ccv']);
        return $donacion;
    }
}


?>
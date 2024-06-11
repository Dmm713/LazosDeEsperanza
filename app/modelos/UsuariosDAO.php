<?php

class UsuariosDAO {
    private mysqli $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getByEmail($email):Usuario|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows >= 1) {
            $usuario = $result->fetch_object(Usuario::class);
            return $usuario;
        } else {
            return null;
        }
    } 

    public function getBySid($sid):Usuario|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE sid = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
        $stmt->bind_param('s', $sid);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows >= 1) {
            $usuario = $result->fetch_object(Usuario::class);
            return $usuario;
        } else {
            return null;
        }
    } 

    public function getById($idUsuario):Usuario|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE idUsuario = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
        $stmt->bind_param('i', $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows >= 1) {
            $usuario = $result->fetch_object(Usuario::class);
            return $usuario;
        } else {
            return null;
        }
    } 

    public function getAllUsuarios():array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM usuarios")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $array_usuarios = array();
        while($usuario = $result->fetch_object(Usuario::class)) {
            $array_usuarios[] = $usuario;
        }
        return $array_usuarios;
    }

    function insert(Usuario $usuario): int|bool {
        if(!$stmt = $this->conn->prepare("INSERT INTO usuarios (nombre, apellidos, direccion, ciego, email, password, rol, foto, sid) VALUES (?,?,?,?,?,?,?,?,?)")) {
            die("Error al preparar la consulta insert: " . $this->conn->error );
        }
        $nombre = $usuario->getNombre();
        $apellidos = $usuario->getApellidos();
        $direccion = $usuario->getDireccion();
        $ciego = $usuario->getCiego();
        $email = $usuario->getEmail();
        $password = $usuario->getPassword();
        $rol = $usuario->getRol();
        $foto = $usuario->getFoto();
        $sid = $usuario->getSid();
        $stmt->bind_param('sssssssss', $nombre, $apellidos, $direccion, $ciego, $email, $password, $rol, $foto, $sid);
        if($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    function borrarUsuario($idUsuario):string|null {
        $foto = null;
        if ($usuario = $this->getById($idUsuario)) {
            $foto = $usuario->getFoto();
        }
        if(!$stmt = $this->conn->prepare("DELETE FROM usuarios WHERE idUsuario = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
        $stmt->bind_param('i', $idUsuario);
        $stmt->execute();
        if($stmt->affected_rows == 1) {
            return $foto;
        } else {
            return null;
        }
    }

    public function update($usuario, $fotoAntigua = null) {
        if(!$stmt = $this->conn->prepare("UPDATE usuarios SET nombre=?, apellidos=?, direccion=?, ciego=?, rol=?, foto=? WHERE idUsuario=?")) {
            die("Error al preparar la consulta update: " . $this->conn->error );
        }
        $nombre = $usuario->getNombre();
        $apellidos = $usuario->getApellidos();
        $direccion = $usuario->getDireccion();
        $ciego = $usuario->getCiego();
        $rol = $usuario->getRol();
        $foto = $usuario->getFoto();
        $idUsuario = $usuario->getIdUsuario();
        $stmt->bind_param('ssssssi', $nombre, $apellidos, $direccion, $ciego, $rol, $foto, $idUsuario);
        return $stmt->execute();
    }

    public function getUsuarioById($idUsuario): ?Usuario {
        // Preparar la consulta SQL
        $sql = "SELECT * FROM usuarios WHERE idUsuario = ?";
        
        try {
            // Preparar la declaración
            if (!$stmt = $this->conn->prepare($sql)) {
                throw new Exception("Error en la SQL: " . $this->conn->error);
            }
    
            // Asociar las variables a los parámetros
            $stmt->bind_param('i', $idUsuario);
    
            // Ejecutar la consulta
            $stmt->execute();
    
            // Obtener el resultado
            $result = $stmt->get_result();
    
            // Verificar si hay algún resultado
            if ($result->num_rows >= 1) {
                // Devolver un objeto de la clase Usuario
                return $result->fetch_object(Usuario::class);
            } else {
                // Si no se encuentran resultados, devolver null
                return null;
            }
        } catch (Exception $e) {
            // Manejar excepciones y mostrar un mensaje de error
            echo "Se ha producido un error: " . $e->getMessage();
            return null;
        } finally {
            // Cerrar la declaración
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }
    
}

?>

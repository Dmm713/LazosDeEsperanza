<?php

class UsuariosDAO {
    private mysqli $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Obtiene un usuario de la BD en función del email
     * @return Usuario Devuelve un Objeto de la clase Usuario o null si no existe
     */
    public function getByEmail($email):Usuario|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('s',$email);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Mensaje, sino null
        if($result->num_rows >= 1){
            $usuario = $result->fetch_object(Usuario::class);
            return $usuario;
        }
        else{
            return null;
        }
    } 


    public function getBySid($sid):Usuario|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE sid = ?"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('s',$sid);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Mensaje, sino null
        if($result->num_rows >= 1){
            $usuario = $result->fetch_object(Usuario::class);
            return $usuario;
        }
        else{
            return null;
        }
    } 

    public function getById($idUsuario):Usuario|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE idUsuario = ?"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$idUsuario);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Mensaje, sino null
        if($result->num_rows >= 1){
            $usuario = $result->fetch_object(Usuario::class);
            return $usuario;
        }
        else{
            return null;
        }
    } 

    /**
     * Obtiene todos los usuarios de la tabla mensajes
     */
    public function getAllUsuarios():array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM usuarios"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_usuarios = array();
        
        while($usuario = $result->fetch_object(Usuario::class)){
            $array_usuarios[] = $usuario;
        }
        return $array_usuarios;
    }


    /**
     * Inserta en la base de datos el usuario que recibe como parámetro
     * @return idUsuario Devuelve el id autonumérico que se le ha asignado al usuario o false en caso de error
     */
    function insert(Usuario $usuario): int|bool{
        if(!$stmt = $this->conn->prepare("INSERT INTO usuarios (nombre, apellidos, direccion, ciego, email, password, rol, foto, sid) VALUES (?,?,?,?,?,?,?,?,?)")){
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
        $stmt->bind_param('sssssssss',$nombre, $apellidos, $direccion, $ciego, $email, $password, $rol, $foto, $sid);
        if($stmt->execute()){
            return $stmt->insert_id;
        }
        else{
            return false;
        }
    }


    function borrarUsuario($idUsuario):string|null {
        // Obtener el nombre del archivo de la foto
        $foto = null;
        if ($usuario = $this->getById($idUsuario)) {
            $foto = $usuario->getFoto();
        }

        if(!$stmt = $this->conn->prepare("DELETE FROM usuarios WHERE idUsuario = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i', $idUsuario);
        //Ejecutamos la SQL
        $stmt->execute();
        //Comprobamos si ha borrado algún registro o no
        if($stmt->affected_rows == 1) {
            return $foto;
        } else {
            return null;
        }
    }

    public function update($usuario, $fotoAntigua = null){
        if(!$stmt = $this->conn->prepare("UPDATE usuarios SET nombre=?, apellidos=?, direccion=?, ciego=?, rol=?, foto=? WHERE idUsuario=?")){
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
    

}
?>

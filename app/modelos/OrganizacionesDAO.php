<?php

class OrganizacionesDAO {
    private mysqli $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Obtiene una organizacion de la BD en función del email
     * @return Organizacion Devuelve un Objeto de la clase Organizacion o null si no existe
     */
    public function getByEmail($email):Organizacion|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM organizaciones WHERE email = ?"))
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
            $organizacion = $result->fetch_object(Organizacion::class);
            return $organizacion;
        }
        else{
            return null;
        }
    } 


    public function getBySid($sid):Organizacion|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM organizaciones WHERE sid = ?"))
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
            $organizacion = $result->fetch_object(Organizacion::class);
            return $organizacion;
        }
        else{
            return null;
        }
    } 

    public function getOrganizacionById($idOrganizacion):Organizacion|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM organizaciones WHERE idOrganizacion = ?"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$idOrganizacion);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Mensaje, sino null
        if($result->num_rows >= 1){
            $organizacion = $result->fetch_object(Organizacion::class);
            return $organizacion;
        }
        else{
            return null;
        }
    } 
 
    /**
     * Obtiene todos los usuarios de la tabla mensajes
     */
    public function getAllOrganizaciones():array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM organizaciones"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_organizaciones = array();
        
        while($organizacion = $result->fetch_object(Organizacion::class)){
            $array_organizaciones[] = $organizacion;
        }
        return $array_organizaciones;
    }


    /**
     * Inserta en la base de datos el usuario que recibe como parámetro
     * @return idOrganizacion Devuelve el id autonumérico que se le ha asignado al usuario o false en caso de error
     */
    function insert(Organizacion $organizacion): int|bool{
        if(!$stmt = $this->conn->prepare("INSERT INTO organizaciones (nombre, descripcion, sitioWeb, telefono, email, password, direccion, foto, ciego, rol, sid) VALUES (?,?,?,?,?,?,?,?,?,?,?)")){
            die("Error al preparar la consulta insert: " . $this->conn->error );
        }
        $nombre = $organizacion->getNombre();
        $descripcion = $organizacion->getDescripcion();
        $sitioWeb = $organizacion->getSitioWeb();
        $telefono = $organizacion->getTelefono();
        $email = $organizacion->getEmail();
        $password = $organizacion->getPassword();
        $direccion = $organizacion->getDireccion();
        $foto = $organizacion->getFoto();
        $ciego = $organizacion->getCiego();
        $rol = $organizacion->getRol();
        $sid = $organizacion->getSid();
        $stmt->bind_param('sssssssssss',$nombre, $descripcion, $sitioWeb, $telefono, $email, $password, $direccion, $foto, $ciego, $rol, $sid);
        if($stmt->execute()){
            return $stmt->insert_id;
        }
        else{
            return false;
        }
    }


    public function update($organizacion, $fotoAntigua = null){
        if(!$stmt = $this->conn->prepare("UPDATE organizaciones SET nombre=?, descripcion=?, sitioWeb=?, telefono=?, direccion=?, foto=?, ciego=?, rol=? WHERE idOrganizacion=?")){
            die("Error al preparar la consulta update: " . $this->conn->error );
        }
        $nombre = $organizacion->getNombre();
        $descripcion = $organizacion->getDescripcion();
        $sitioWeb = $organizacion->getSitioWeb();
        $telefono = $organizacion->getTelefono();
        $direccion = $organizacion->getDireccion();
        $foto = $organizacion->getFoto();
        $ciego = $organizacion->getCiego();
        $rol = $organizacion->getRol();
        $idOrganizacion = $organizacion->getIdOrganizacion();
        $stmt->bind_param('ssssssssi', $nombre, $descripcion, $sitioWeb, $telefono, $direccion, $foto, $ciego, $rol, $idOrganizacion);
        return $stmt->execute();
    }
    


    function borrarOrganizacion($id):bool{

        if(!$stmt = $this->conn->prepare("DELETE FROM organizaciones WHERE idOrganizacion = ?"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$id);
        //Ejecutamos la SQL
        $stmt->execute();
        //Comprobamos si ha borrado algún registro o no
        if($stmt->affected_rows==1){
            return true;
        }
        else{
            return false;
        }
        
    }
 
}
?>

<?php 

class ControladorOrganizaciones{
    public function ver(){
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        //Creamos el objeto OrganizacionesDAO para acceder a BBDD a través de este objeto
        $organizacionesDAO = new OrganizacionesDAO($conn);

        //Obtener el mensaje
        $idOrganicacion = htmlspecialchars($_GET['idOrganicacion']);
        $organizacion = $organizacionesDAO->getById($idOrganicacion);

        require 'app/vistas/ver_organizacion.php';
    }

    public function inicio(){
        


         //Creamos la conexión utilizando la clase que hemos creado
         $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
         $conn = $connexionDB->getConnexion();
        
         //Comprobamos la conexión
         if(!$conn) {
             echo "Error en la conexión a la base de datos";
             die();
         }
    
         //Creamos el objeto OrganizacionesDAO para acceder a BBDD a través de este objeto
         $organizacionesDAO = new OrganizacionesDAO($conn);
        
         //Obtenemos las organizaciones
         $organizacion = $organizacionesDAO->getAll();
         //Incluyo la vista
         require 'app/vistas/inicio.php';
    }
    

    public function borrar(){
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        //Creamos el objeto OrganizacionesDAO para acceder a BBDD a través de este objeto
        $organizacionesDAO = new OrganizacionesDAO($conn);

        //Obtener el mensaje
        $idOrganicacion = htmlspecialchars($_GET['idOrganicacion']);
        $organizacion = $organizacionesDAO->getById($idOrganicacion);

        //Comprobamos que mensaje pertenece al usuario conectado
        if(Sesion::getUsuario()->getIdUsuario()==$organizacion->getIdUsuario()){
            $organizacionesDAO->delete($idOrganicacion);
        }
        else
        {
            guardarMensaje("No puedes borrar este mensaje");
        }

        header('location: index.php');
    }

    public function editar(){
        $error ='';


        //Conectamos con la bD
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        //Obtengo el id del mensaje que viene por GET
        $idOrganicacion = htmlspecialchars($_GET['idOrganicacion']);
        //Obtengo el mensaje de la BD
        $organizacionesDAO = new OrganizacionesDAO($conn);
        $organizacion = $organizacionesDAO->getById($idOrganicacion);

        //Obtenemos los usuarios de la BD para el desplegable
        $usuariosDAO = new UsuariosDAO($conn);
        $usuarios = $usuariosDAO->getAll();

        //Cuando se envíe el formulario actualizo el mensaje en la BD
        if($_SERVER['REQUEST_METHOD']=='POST'){

            //Limpiamos los datos que vienen del usuario
            $nombre = htmlspecialchars($_POST['nombre']);
            $descripcion = htmlspecialchars($_POST['descripcion']);
            $sitioWeb = htmlspecialchars($_POST['sitioWeb']);
            $telefono = htmlspecialchars($_POST['telefono']);
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $direccion = htmlspecialchars($_POST['direccion']);
            $foto = htmlspecialchars($_POST['foto']);
            //Validamos los datos
            if(empty($titulo) || empty($texto)){
                $error = "Los dos campos son obligatorios";
            }
            else{
                $organizacion->setNombre($nombre);
                $organizacion->setDescripcion($descripcion);
                $organizacion->setSitioWeb($sitioWeb);
                $organizacion->setTelefono($telefono);
                $organizacion->setEmail($email);
                $organizacion->setPassword($password);
                $organizacion->setDireccion($direccion);
                $organizacion->setFoto($foto);

                $organizacionesDAO->update($organizacion);
                header('location: location: index.php');
                die();
            }

        } //if($_SERVER['REQUEST_METHOD']=='POST'){
        
            require 'app/vistas/editar_mensaje.php';
    }

    public function insertar(){
        
        $error ='';

        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        $usuariosDAO = new UsuariosDAO($conn);
        $usuarios = $usuariosDAO->getAll();


        if($_SERVER['REQUEST_METHOD']=='POST'){

            //Limpiamos los datos que vienen del usuario
            $nombre = htmlspecialchars($_POST['nombre']);
            $descripcion = htmlspecialchars($_POST['descripcion']);
            $sitioWeb = htmlspecialchars($_POST['sitioWeb']);
            $telefono = htmlspecialchars($_POST['telefono']);
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $direccion = htmlspecialchars($_POST['direccion']);
            $foto = htmlspecialchars($_POST['foto']);
            //$idUsuario = htmlspecialchars($_POST['idUsuario']);   //Solo necesario si queremos seleccionar usuario en el desplegable

            //Validamos los datos
            if(empty($titulo) || empty($texto)){
                $error = "Los dos campos son obligatorios";
            }
            else{
                //Creamos el objeto OrganizacionesDAO para acceder a BBDD a través de este objeto
                $organizacionesDAO = new OrganizacionesDAO($conn);
                $organizacion = new Organizacion();
                $organizacion->setNombre($nombre);
                $organizacion->setDescripcion($descripcion);
                $organizacion->setSitioWeb($sitioWeb);
                $organizacion->setTelefono($telefono);
                $organizacion->setEmail($email);
                $organizacion->setPassword($password);
                $organizacion->setDireccion($direccion);
                $organizacion->setFoto($foto);
                $organizacionesDAO->insert($organizacion);
                header('location: index.php');
                die();
            }


        }
        require 'app/vistas/insertar_mensaje.php';
    }
}
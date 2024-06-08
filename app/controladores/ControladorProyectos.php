<?php

class ControladorProyectos{

    public function misProyectosOrganizacion(){
        // Verificar si el idOrganizacion está en la sesión
   if (!isset($_SESSION['idOrganizacion'])) {
       echo "ID de organización no encontrado en la sesión.";
       return;
   }

   // Verificar si el rol del usuario es 'Organizacion'
   if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Organizacion') {
       echo "Acceso denegado. Rol insuficiente.";
       return;
   }

   // Obtener el idOrganizacion de la sesión
   $idOrganizacion = $_SESSION['idOrganizacion'];

   // Conectar a la base de datos
   $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
   $conn = $connexionDB->getConnexion();

   // Obtener la organización seleccionada por el ID
   $organizacionesDAO = new OrganizacionesDAO($conn);
   $organizacion = $organizacionesDAO->getById($idOrganizacion);

   // Verificar si la organización existe
   if (!$organizacion) {
       // Manejar el caso donde la organización no existe
       echo "Organización no encontrada.";
       return;
   }

   // Obtener todos los usuarios
   $usuariosDAO = new UsuariosDAO($conn);
   $usuarios = $usuariosDAO->getAllUsuarios();

   // Obtener todos los eventos de la organización
   $proyectosDAO = new ProyectosDAO($conn);
   $proyectos = $proyectosDAO->getProyectosByOrganizacion($idOrganizacion);

   // Incluir la vista y pasar los datos necesarios
   require 'app/vistas/misProyectos.php';
   }

   public function crearProyecto(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Verificar si el idOrganizacion está en la sesión
        if (!isset($_SESSION['idOrganizacion'])) {
            echo "ID de organización no encontrado en la sesión.";
            return;
        }

        // Obtener el idOrganizacion de la sesión
        $idOrganizacion = $_SESSION['idOrganizacion'];

        // Conectar a la base de datos
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        // Obtener los datos del formulario
        $titulo = htmlspecialchars($_POST['titulo']);
        $descripcion = htmlspecialchars($_POST['descripcion']);
        $fechaInicio = htmlspecialchars($_POST['fechaInicio']);
        $fechaFin = htmlspecialchars($_POST['fechaFin']);
        $objetivoFinanciero = htmlspecialchars($_POST['objetivoFinanciero']);
        $fotoProyecto = '';

        // Manejar la subida de la foto del proyecto
        if (!empty($_FILES['fotoProyecto']['name'])) {
            if (
                $_FILES['fotoProyecto']['type'] != 'image/jpeg' &&
                $_FILES['fotoProyecto']['type'] != 'image/webp' &&
                $_FILES['fotoProyecto']['type'] != 'image/png'
            ) {
                echo "La foto no tiene el formato admitido, debe ser jpg, webp o png";
                return;
            } else {
                $fotoProyecto = generarNombreArchivo($_FILES['fotoProyecto']['name']);
                while (file_exists("web/fotosProyectos/$fotoProyecto")) {
                    $fotoProyecto = generarNombreArchivo($_FILES['fotoProyecto']['name']);
                }
                if (!move_uploaded_file($_FILES['fotoProyecto']['tmp_name'], "web/fotosProyectos/$fotoProyecto")) {
                    die("Error al copiar la foto a la carpeta fotosProyectos");
                }
            }
        }

        // Crear el objeto Proyecto y guardarlo en la base de datos
        $proyecto = new Proyecto();
        $proyecto->setIdOrganizacion($idOrganizacion);
        $proyecto->setTitulo($titulo);
        $proyecto->setDescripcion($descripcion);
        $proyecto->setFechaInicio($fechaInicio);
        $proyecto->setFechaFin($fechaFin);
        $proyecto->setObjetivoFinanciero($objetivoFinanciero);
        $proyecto->setFotoProyecto($fotoProyecto);

        $proyectosDAO = new ProyectosDAO($conn);
        if ($proyectosDAO->insert($proyecto)) {
            header('location: index.php?accion=misProyectosOrganizacion');
            die();
        } else {
            echo "No se ha podido crear el proyecto.";
        }
    } else {
        // Mostrar el formulario de creación de proyectos
        require 'app/vistas/crearProyecto.php';
    }
}

}
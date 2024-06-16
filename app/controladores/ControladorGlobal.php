<?php 

class ControladorGlobal{
   
    public function inicio(){
              // Conectar a la base de datos
              $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
              $conn = $connexionDB->getConnexion();
              
              // Obtener todas las organizaciones
              $organizacionesDAO = new OrganizacionesDAO($conn);
              $organizaciones = $organizacionesDAO->getAllOrganizaciones();

              $usuariosDAO = new UsuariosDAO($conn);
              $usuarios = $usuariosDAO->getAllUsuarios();
             
         //Incluyo la vista
         require 'app/vistas/inicio.php';
    }

    public function paginaPrincipal(){
        
         // Conectar a la base de datos
         $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
         $conn = $connexionDB->getConnexion();
         
       
        // Obtener todas las organizaciones
        $organizacionesDAO = new OrganizacionesDAO($conn);
        $organizaciones = $organizacionesDAO->getAllOrganizaciones();

        $usuariosDAO = new UsuariosDAO($conn);
        $usuarios = $usuariosDAO->getAllUsuarios();

        // Obtener todos los testimonios
        $testimoniosDAO = new TestimoniosDAO($conn);
        $testimonios = $testimoniosDAO->getAllTestimonios();
         require 'app/vistas/paginaPrincipal.php';
          
    }
    public function paginaOrganizacion($idOrganizacion) {
          // Conectar a la base de datos
          $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
          $conn = $connexionDB->getConnexion();
  
          // Obtener la organización seleccionada por el ID
          $organizacionesDAO = new OrganizacionesDAO($conn);
          $organizacion = $organizacionesDAO->getOrganizacionById($idOrganizacion);
  
          // Obtener todos los usuarios
          $usuariosDAO = new UsuariosDAO($conn);
          $usuarios = $usuariosDAO->getAllUsuarios();
  
          // Obtener los testimonios relacionados con la organización
          $testimoniosDAO = new TestimoniosDAO($conn);
          $testimonios = $testimoniosDAO->getTestimoniosByOrganizacion($idOrganizacion);
  
          // Obtener los proyectos de la organización
          $proyectosDAO = new ProyectosDAO($conn);
          $proyectos = $proyectosDAO->getProyectosByOrganizacion($idOrganizacion);
  
          // Obtener los voluntarios del usuario en sesión para los proyectos de la organización
          $voluntariosDAO = new VoluntariosDAO($conn);
          $idUsuario = isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : null;
          $voluntariados = [];
          if ($idUsuario) {
              $voluntariados = $voluntariosDAO->getVoluntariadosByUsuario($idUsuario);
          }
  
          // Incluir la vista
          require 'app/vistas/paginaOrganizacion.php';
  
 }
 

    public function paginaPrincipalRegistrar() {
         // Conectar a la base de datos
         $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
         $conn = $connexionDB->getConnexion();
         
       
        // Obtener todas las organizaciones
        $organizacionesDAO = new OrganizacionesDAO($conn);
        $organizaciones = $organizacionesDAO->getAllOrganizaciones();

        $usuariosDAO = new UsuariosDAO($conn);
        $usuarios = $usuariosDAO->getAllUsuarios();

        // Obtener todos los testimonios
        $testimoniosDAO = new TestimoniosDAO($conn);
        $testimonios = $testimoniosDAO->getAllTestimonios();
        require 'app/vistas/paginaPrincipal.php';
    }
    

    public function inscribirseVoluntariado() {
     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         // Conectar a la base de datos
         $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
         $conn = $connexionDB->getConnexion();
 
         $idProyecto = $_POST['idProyecto'];
         $idUsuario = $_SESSION['idUsuario']; // Asumiendo que el usuario está en sesión
         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];
 
         $voluntario = new Voluntario();
         $voluntario->setIdProyecto($idProyecto);
         $voluntario->setIdUsuario($idUsuario);
         $voluntario->setFechaInicio($fechaInicio);
         $voluntario->setFechaFin($fechaFin);
 
         $voluntariosDAO = new VoluntariosDAO($conn);
         if ($voluntariosDAO->insert($voluntario)) {
             // Redirigir o mostrar mensaje de éxito
             header('Location: index.php?accion=paginaOrganizacion&idOrganizacion=' . $this->getOrganizacionIdByProyectoId($idProyecto));
             exit();
         } else {
             // Manejar error
             echo "Error al inscribirse.";
         }
     }
 }
 
 private function getOrganizacionIdByProyectoId($idProyecto) {
     // Conectar a la base de datos
     $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
     $conn = $connexionDB->getConnexion();
 
     $proyectosDAO = new ProyectosDAO($conn);
     $proyecto = $proyectosDAO->getProyectoById($idProyecto);
 
     return $proyecto->getIdOrganizacion();
 }

 public function verTodosLosEventos() {
    $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
    $conn = $connexionDB->getConnexion();
    $eventosDAO = new EventosDAO($conn);
    $eventos = $eventosDAO->getAllEventos(); // Asumiendo que existe un método getAllEventos en EventosDAO
    require 'app/vistas/verTodosLosEventos.php';
}

}
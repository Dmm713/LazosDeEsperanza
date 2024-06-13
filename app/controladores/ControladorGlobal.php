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
 
     // Obtener el rol del usuario en sesión
     $rol = isset($_GET['rol']) ? $_GET['rol'] : '';
 
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
        require 'app/vistas/paginaPrincipal.php';
    }
    

 



}
<?php 

class ControladorGlobal{
   
    public function inicio(){
              // Conectar a la base de datos
              $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
              $conn = $connexionDB->getConnexion();
              
              // Obtener todas las organizaciones
              $organizacionesDAO = new OrganizacionesDAO($conn);
              $organizaciones = $organizacionesDAO->getAll();

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

         $organizaciones = $organizacionesDAO->getAll();

         $usuariosDAO = new UsuariosDAO($conn);
         $usuarios = $usuariosDAO->getAllUsuarios();
        
         if (isset($_SESSION['accessibility'])) {
             if ($_SESSION['accessibility'] === "yes") {
                 header('location: app/vistas/paginaPrincipal.php?accessibility=yes');
                 die();
             } else {
                 header('location: app/vistas/paginaPrincipal.php?accessibility=no');
                 die();
             }
         }
          
    }

    public function paginaPrincipalRegistrar() {
         // Conectar a la base de datos
         $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
         $conn = $connexionDB->getConnexion();
         
         // Obtener todas las organizaciones
         $organizacionesDAO = new OrganizacionesDAO($conn);
         $organizaciones = $organizacionesDAO->getAll();

        $usuariosDAO = new UsuariosDAO($conn);
        $usuarios = $usuariosDAO->getAllUsuarios();
        // Verificamos si el parámetro accessibility está presente en la solicitud
        if (isset($_GET['accessibility']) && $_GET['accessibility'] === 'yes') {
            // Redirigimos a la página principal con accesibilidad activada
            header('location: app/vistas/paginaPrincipal.php?accessibility=yes');
        } else {
            // Redirigimos a la página principal con accesibilidad desactivada
            header('location: app/vistas/paginaPrincipal.php?accessibility=no');
        }
    }
    
}
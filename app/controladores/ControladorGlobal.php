<?php 

class ControladorGlobal{
   
    public function inicio(){
         //Incluyo la vista
         require 'app/vistas/inicio.php';
    }

    public function paginaPrincipal(){
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
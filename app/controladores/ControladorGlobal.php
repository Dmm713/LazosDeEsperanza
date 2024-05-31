<?php 

class ControladorGlobal{
   

    public function inicio(){
         //Incluyo la vista
         require 'app/vistas/inicio.php';
    }


    public function paginaPrincipal($ciego){
        include '../modelos/Sesion.php';

        if($ciego === "SI"){
            header('location: app/vistas/paginaPrincipal.php?accessibility=SI');
        }else {
            header('location: app/vistas/paginaPrincipal.php?accessibility=NO');
        }
    }

    public function paginaPrincipalRegistrar() {
        // Verificamos si el parámetro accessibility está presente en la solicitud
        if (isset($_GET['accessibility']) && $_GET['accessibility'] === 'SI') {
            // Redirigimos a la página principal con accesibilidad activada
            header('location: app/vistas/paginaPrincipal.php?accessibility=SI');
        } else {
            // Redirigimos a la página principal con accesibilidad desactivada
            header('location: app/vistas/paginaPrincipal.php?accessibility=NO');
        }
    }
    
}
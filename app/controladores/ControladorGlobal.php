<?php 

class ControladorGlobal{
   

    public function inicio(){
         //Incluyo la vista
         require 'app/vistas/inicio.php';
    }


    public function paginaPrincipal($ciego){
        if($ciego === "yes"){
            header('location: app/vistas/paginaPrincipal.php?accessibility=yes');
        }else {
            header('location: app/vistas/paginaPrincipal.php?accessibility=no');
        }
    }
}
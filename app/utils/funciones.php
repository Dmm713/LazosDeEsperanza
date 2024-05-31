<?php 
/**
 * Genera un hash aleatorio para un nombre de arhivo manteniendo la extensión original
 */
function generarNombreArchivo(string $nombreOriginal):string {
    $nuevoNombre = md5(time()+rand());
    $partes = explode('.',$nombreOriginal);
    $extension = $partes[count($partes)-1];
    return $nuevoNombre.'.'.$extension;
}

function guardarMensaje2($mensaje){
    $_SESSION['error']=$mensaje;
}

function guardarMensaje($mensaje) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $_SESSION['mensaje'] = $mensaje;
}

function imprimirMensaje(){
    if(isset($_SESSION['error'])){
        echo '<div class="error" id="mensajeError">'.$_SESSION['error'].'</div>';
        unset($_SESSION['error']);
    } 
}


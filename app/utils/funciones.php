<?php 
/**
 * Genera un hash aleatorio para un nombre de arhivo manteniendo la extensión original
 */
function generarNombreArchivo($nombreOriginal) {
    $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
    $nombreBase = basename($nombreOriginal, '.' . $extension);
    $nombreBase = preg_replace('/[^A-Za-z0-9_\-]/', '_', $nombreBase);
    return $nombreBase . '_' . time() . '.' . $extension;
}



function guardarMensaje($mensaje){
    $_SESSION['error'] = $mensaje;
}

function imprimirMensaje(){
    if(isset($_SESSION['error'])){
        echo '<div class="error" id="mensajeError">'.$_SESSION['error'].'</div>';
        unset($_SESSION['error']);
    } 
}


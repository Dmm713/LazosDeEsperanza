<?php
require_once 'app/config/config.php';
require_once 'app/modelos/ConnexionDB.php';
require_once 'app/modelos/Comunicacion.php';
require_once 'app/modelos/ComunicacionesDAO.php';
require_once 'app/modelos/Usuario.php';
require_once 'app/modelos/UsuariosDAO.php';
require_once 'app/modelos/Donacion.php';
require_once 'app/modelos/DonacionesDAO.php';
require_once 'app/modelos/Evento.php';
require_once 'app/modelos/EventosDAO.php';
require_once 'app/modelos/Organizacion.php';
require_once 'app/modelos/OrganizacionesDAO.php';
require_once 'app/modelos/Proyecto.php';
require_once 'app/modelos/ProyectosDAO.php';
require_once 'app/modelos/Voluntario.php';
require_once 'app/modelos/VoluntariosDAO.php';
require_once 'app/controladores/ControladorOrganizaciones.php';
require_once 'app/controladores/ControladorGlobal.php';
require_once 'app/controladores/ControladorUsuarios.php';
require_once 'app/utils/funciones.php';
//Uso de variables de sesión
session_start();
//Mapa de enrutamiento
$mapa = array(
    'inicio'=>array("controlador"=>'ControladorGlobal',
                    'metodo'=>'inicio',
                    'privada'=>false),
    'paginaPrincipal'=>array("controlador"=>'ControladorGlobal',
                    'metodo'=>'paginaPrincipal',
                    'privada'=>false),
    'paginaPrincipalRegistrar'=>array("controlador"=>'ControladorGlobal',
                    'metodo'=>'paginaPrincipalRegistrar',
                    'privada'=>false),     
    'paginaOrganizacion'=>array("controlador"=>'ControladorGlobal',
                    'metodo'=>'paginaOrganizacion',
                    'privada'=>false),             
    'verTodosLosUsuarios'=>array("controlador"=>'ControladorUsuarios',
                         'metodo'=>'verTodosLosUsuarios', 
                         'privada'=>true),
    'insertarUsuario'=>array('controlador'=>'ControladorUsuarios',
                              'metodo'=>'insertarUsuario', 
                              'privada'=>true),
    'borrarUsuario'=>array('controlador'=>'ControladorUsuarios',
                            'metodo'=>'borrarUsuario', 
                            'privada'=>true),
    'editarUsuario'=>array('controlador'=>'ControladorUsuarios',
                            'metodo'=>'editarUsuario', 
                            'privada'=>true),
    'subirFotoAjax'=>array('controlador'=>'ControladorUsuarios',
                            'metodo'=>'subirFotoAjax', 
                            'privada'=>true),
    'verTodasLasOrganizaciones'=>array("controlador"=>'ControladorOrganizaciones',
                            'metodo'=>'verTodasLasOrganizaciones', 
                            'privada'=>true),
    'insertarOrganizacion'=>array('controlador'=>'ControladorOrganizaciones',
                                 'metodo'=>'insertarOrganizacion', 
                                 'privada'=>true),
    'borrarOrganizacion'=>array('controlador'=>'ControladorOrganizaciones',
                               'metodo'=>'borrarOrganizacion', 
                               'privada'=>true),
    'editarOrganizacion'=>array('controlador'=>'ControladorOrganizaciones',
                               'metodo'=>'editarOrganizacion', 
                               'privada'=>true),
    'subirFotoAjaxOrganizaciones'=>array('controlador'=>'ControladorOrganizaciones',
                               'metodo'=>'subirFotoAjaxOrganizaciones', 
                               'privada'=>true),
    'misEventosOrganizacion'=>array('controlador'=>'ControladorOrganizaciones',
                               'metodo'=>'misEventosOrganizacion', 
                               'privada'=>true),
    'crearEvento'=>array('controlador'=>'ControladorOrganizaciones',
                               'metodo'=>'crearEvento', 
                               'privada'=>true),
    'editarEvento'=>array('controlador'=>'ControladorOrganizaciones',
                               'metodo'=>'editarEvento', 
                               'privada'=>true),
    'borrarEvento'=>array('controlador'=>'ControladorOrganizaciones',
                               'metodo'=>'borrarEvento', 
                               'privada'=>true),
    'login'=>array('controlador'=>'ControladorUsuarios', 
                   'metodo'=>'login', 
                   'privada'=>false),
    'loginOrganizacion'=>array('controlador'=>'ControladorOrganizaciones', 
                   'metodo'=>'loginOrganizacion', 
                   'privada'=>false),
    'logout'=>array('controlador'=>'ControladorUsuarios', 
                    'metodo'=>'logout', 
                    'privada'=>true),
    'registrar'=>array('controlador'=>'ControladorUsuarios', 
                    'metodo'=>'registrar', 
                    'privada'=>false),
    'registrarOrganizacion'=>array('controlador'=>'ControladorOrganizaciones', 
                    'metodo'=>'registrarOrganizacion', 
                    'privada'=>false),
    'insertar_favorito'=>array('controlador'=>'ControladorFavoritos', 
                       'metodo'=>'insertar', 
                       'privada'=>false),                       
    'borrar_favorito'=>array('controlador'=>'ControladorFavoritos', 
                       'metodo'=>'borrar', 
                       'privada'=>false),                                              
);

foreach ($mapa as $i => $valor) {
    $mapa[$i . '&accessibility=yes'] = $valor;
    $mapa[$i . '&accessibility=no'] = $valor;
}

//Parseo de la ruta
if(isset($_GET['accion'])){ //Compruebo si me han pasado una acción concreta, sino pongo la accción por defecto inicio
    if(isset($mapa[$_GET['accion']])){  //Compruebo si la accción existe en el mapa, sino muestro error 404
        if (isset($_POST['accessibility'])) {
            $_SESSION['accessibility'] = $_POST['accessibility'];
        }

        $accion = $_GET['accion'];

        if (str_contains($accion, '&accesibilty')) {
            $partes = explode("&accessibility=", $accion);

            if ($partes[1] === "yes") {
                $_SESSION['accessibility'] = "yes";
            } else {
                $_SESSION['accessibility'] = "no";
            }

            $accion = $partes[0];
        }

        error_log("Acción: " . $accion);
    } else {
        //La acción no existe
        header('Status: 404 Not found');
        echo 'Página no encontrada';
        die();
    }
}else{
    $accion='inicio';   //Acción por defecto
}

//Si existe la cookie y no ha iniciado sesión, le iniciamos sesión de forma automática
if( !isset($_SESSION['email']) && isset($_COOKIE['sid'])){
// if(!Sesion::existeSesion() && isset($_COOKIE['sid'])){
    //Conectamos con la bD
    $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
    $conn = $connexionDB->getConnexion();
    
    //Nos conectamos para obtener el id y la foto del usuario
    $usuariosDAO = new UsuariosDAO($conn);
    $organizacionesDAO = new OrganizacionesDAO($conn);
    if($usuario = $usuariosDAO->getBySid($_COOKIE['sid'])){
        $_SESSION['email']=$usuario->getEmail();
        $_SESSION['idUsuario']=$usuario->getIdUsuario();
        $_SESSION['foto']=$usuario->getFoto();
        $_SESSION['rol']=$usuario->getRol();
        // Sesion::iniciarSesion($usuario);
    }
    
    if($organizacion = $organizacionesDAO->getBySid($_COOKIE['sid'])){
        $_SESSION['email']=$organizacion->getEmail();
        $_SESSION['idOrganizacion']=$organizacion->getIdOrganizacion();
        $_SESSION['foto']=$organizacion->getFoto();
        $_SESSION['rol']=$organizacion->getRol();
        // Sesion::iniciarSesion($usuario);
    }
}

//Si la acción es privada compruebo que ha iniciado sesión, sino, lo echamos a index
if(!isset($_SESSION['email']) && $mapa[$accion]['privada']){
// if(!Sesion::existeSesion() && $mapa[$accion]['privada']){
    header('location: index.php');
    guardarMensaje("Debes iniciar sesión para acceder a $accion");
    die();
}

//$acción ya tiene la acción a ejecutar, cogemos el controlador y metodo a ejecutar del mapa
$controlador = $mapa[$accion]['controlador'];
$metodo = $mapa[$accion]['metodo'];

//Ejecutamos el método de la clase controlador
$objeto = new $controlador();

// Verificar si la acción es paginaOrganizacion y pasar el idOrganizacion como parámetro
if ($accion == 'paginaOrganizacion' && isset($_GET['idOrganizacion'])) {
    $idOrganizacion = $_GET['idOrganizacion'];
    $objeto->$metodo($idOrganizacion);
} else if ($accion == 'paginaOrganizacion') {
    // Si la acción es paginaOrganizacion pero no hay idOrganizacion, mostramos un error
    echo "ID de organización no proporcionado.";
} else {
    $objeto->$metodo();
}
?>
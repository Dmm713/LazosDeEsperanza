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
require_once 'app/modelos/Testimonio.php';
require_once 'app/modelos/TestimoniosDAO.php';
require_once 'app/controladores/ControladorOrganizaciones.php';
require_once 'app/controladores/ControladorProyectos.php';
require_once 'app/controladores/ControladorTestimonios.php';
require_once 'app/controladores/ControladorGlobal.php';
require_once 'app/controladores/ControladorUsuarios.php';
require_once 'app/controladores/ControladorDonaciones.php';
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
    'miPerfilUsuario'=>array('controlador'=>'ControladorUsuarios',
                               'metodo'=>'miPerfilUsuario', 
                               'privada'=>true),
    'editarMiPerfilUsuario'=>array('controlador'=>'ControladorUsuarios',
                               'metodo'=>'editarMiPerfilUsuario', 
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
    'crearEventoAdmin'=>array('controlador'=>'ControladorOrganizaciones',
                               'metodo'=>'crearEventoAdmin', 
                               'privada'=>true),
    'editarEvento'=>array('controlador'=>'ControladorOrganizaciones',
                               'metodo'=>'editarEvento', 
                               'privada'=>true),
    'editarEventoAdmin'=>array('controlador'=>'ControladorOrganizaciones',
                               'metodo'=>'editarEventoAdmin', 
                               'privada'=>true),
    'borrarEvento'=>array('controlador'=>'ControladorOrganizaciones',
                               'metodo'=>'borrarEvento', 
                               'privada'=>true),
    'borrarEventoAdmin'=>array('controlador'=>'ControladorOrganizaciones',
                               'metodo'=>'borrarEventoAdmin', 
                               'privada'=>true),
    'misProyectosOrganizacion'=>array('controlador'=>'ControladorProyectos',
                               'metodo'=>'misProyectosOrganizacion',
                               'privada'=>true),
    'crearProyecto'=>array('controlador'=>'ControladorProyectos',
                               'metodo'=>'crearProyecto', 
                               'privada'=>true),
    'crearProyectoAdmin'=>array('controlador'=>'ControladorProyectos',
                               'metodo'=>'crearProyectoAdmin', 
                               'privada'=>true),
    'editarProyecto'=>array('controlador'=>'ControladorProyectos',
                               'metodo'=>'editarProyecto', 
                               'privada'=>true),
    'editarProyectoAdmin'=>array('controlador'=>'ControladorProyectos',
                               'metodo'=>'editarProyectoAdmin', 
                               'privada'=>true),
    'borrarProyecto'=>array('controlador'=>'ControladorProyectos',
                               'metodo'=>'borrarProyecto', 
                               'privada'=>true),
    'borrarProyectoAdmin'=>array('controlador'=>'ControladorProyectos',
                               'metodo'=>'borrarProyectoAdmin', 
                               'privada'=>true),
    'misTestimoniosOrganizacion'=>array('controlador'=>'ControladorTestimonios',
                               'metodo'=>'misTestimoniosOrganizacion',
                               'privada'=>true),
    'crearTestimonio'=>array('controlador'=>'ControladorTestimonios',
                               'metodo'=>'crearTestimonio', 
                               'privada'=>true),
    'crearTestimonioAdmin'=>array('controlador'=>'ControladorTestimonios',
                               'metodo'=>'crearTestimonioAdmin', 
                               'privada'=>true),
    'editarTestimonio'=>array('controlador'=>'ControladorTestimonios',
                               'metodo'=>'editarTestimonio', 
                               'privada'=>true),
    'editarTestimonioAdmin'=>array('controlador'=>'ControladorTestimonios',
                               'metodo'=>'editarTestimonioAdmin', 
                               'privada'=>true),
    'borrarTestimonio'=>array('controlador'=>'ControladorTestimonios',
                               'metodo'=>'borrarTestimonio', 
                               'privada'=>true),
    'borrarTestimonioAdmin'=>array('controlador'=>'ControladorTestimonios',
                               'metodo'=>'borrarTestimonioAdmin', 
                               'privada'=>true),
    'miPerfilOrganizacion'=>array('controlador'=>'ControladorOrganizaciones',
                               'metodo'=>'miPerfilOrganizacion', 
                               'privada'=>true),
    'editarMiPerfilOrganizacion'=>array('controlador'=>'ControladorOrganizaciones',
                               'metodo'=>'editarMiPerfilOrganizacion', 
                               'privada'=>true),
    'actualizarFoto'=>array('controlador'=>'ControladorOrganizaciones',
                               'metodo'=>'actualizarFoto', 
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
    'inscribirseVoluntariado'=>array('controlador'=>'ControladorGlobal', 
                       'metodo'=>'inscribirseVoluntariado', 
                       'privada'=>false),
    'inscribirseVoluntariadoTodosProyectos'=>array('controlador'=>'ControladorProyectos', 
                       'metodo'=>'inscribirseVoluntariadoTodosProyectos', 
                       'privada'=>false),
    'procesarDonacion' => array(
                    'controlador' => 'ControladorDonaciones',
                    'metodo' => 'procesarDonacion',
                    'privada' => true),
    'verTodosLosEventos' => array(
                        'controlador' => 'ControladorGlobal',
                        'metodo' => 'verTodosLosEventos',
                        'privada' => true),
    'verTodosLosEventosAdmin' => array(
                            'controlador' => 'ControladorGlobal',
                            'metodo' => 'verTodosLosEventosAdmin',
                            'privada' => true),
    'verTodosLosProyectos' => array(
                            'controlador' => 'ControladorProyectos',
                            'metodo' => 'verTodosLosProyectos',
                            'privada' => true),
    'verTodosLosProyectosAdmin' => array(
                                'controlador' => 'ControladorProyectos',
                                'metodo' => 'verTodosLosProyectosAdmin',
                                'privada' => true),
    'verTodosLosTestimonios' => array(
                                'controlador' => 'ControladorTestimonios',
                                'metodo' => 'verTodosLosTestimonios',
                                'privada' => true),
    'verTodosLosTestimoniosAdmin' => array(
                                    'controlador' => 'ControladorTestimonios',
                                    'metodo' => 'verTodosLosTestimoniosAdmin',
                                    'privada' => true),
    'verMisVoluntariados' => array(
                                    'controlador' => 'ControladorUsuarios',
                                    'metodo' => 'misVoluntariados',
                                    'privada' => true
                                ),
    'misDonaciones' => array(
                           'controlador' => 'ControladorDonaciones',
                           'metodo' => 'misDonaciones',
                           'privada' => true
                           ),
    'donacionesOrganizacion' => array(
                            'controlador' => 'ControladorDonaciones',
                            'metodo' => 'donacionesOrganizacion',
                            'privada' => true
                            ),
    'voluntariosOrganizacion' => array(
                                'controlador' => 'ControladorOrganizaciones',
                                'metodo' => 'verVoluntarios', // Cambiar 'voluntariosOrganizacion' a 'verVoluntarios'
                                'privada' => true
                            ),
    'borrarVoluntario'=>array('controlador'=>'ControladorOrganizaciones',
                                'metodo'=>'borrarVoluntario',
                                'privada'=>true),
    'borrarMisVoluntariados'=>array('controlador'=>'ControladorUsuarios',
                                'metodo'=>'borrarMisVoluntariados',
                                'privada'=>true),
    'borrarDonacion' => array(
                                'controlador' => 'ControladorDonaciones',
                                'metodo' => 'borrarDonacion',
                                     'privada' => true
                                ),
    'sobreMi' => array(
                    'controlador' => 'ControladorGlobal',
                    'metodo' => 'sobreMi',
                    'privada' => true
                    ),
                                
                        
                                
                                          
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
} else if ($accion == 'miPerfilOrganizacion' && isset($_SESSION['idOrganizacion'])) {
    $idOrganizacion = $_SESSION['idOrganizacion'];
    $objeto->$metodo($idOrganizacion);
} else if ($accion == 'miPerfilUsuario' && isset($_SESSION['idUsuario'])) {
    $idUsuario = $_SESSION['idUsuario'];
    $objeto->$metodo($idUsuario);
} else {
    $objeto->$metodo();
}
?>

<?php 

class ControladorOrganizaciones{
    public function registrarOrganizacion() {
        $error = '';   
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Limpiamos los datos
            $nombre = htmlentities($_POST['nombre']);
            $descripcion = htmlentities($_POST['descripcion']);
            $sitioWeb = htmlentities($_POST['sitioWeb']);
            $telefono = htmlentities($_POST['telefono']);
            $email = htmlentities($_POST['email']);
            $password = htmlentities($_POST['password']);
            $direccion = htmlentities($_POST['direccion']);
            $foto = '';            
            $ciego = htmlentities($_POST['ciego']);
            $rol = htmlentities($_POST['rol']);
    
            // Validación y conexión con la BD
            $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnexion();
    
            $organizacionesDAO = new OrganizacionesDAO($conn);
            if ($organizacionesDAO->getByEmail($email) != null) {
                $error = "Ya hay una organización con ese email";
            } else {
                if ($_FILES['foto']['type'] != 'image/jpeg' &&
                    $_FILES['foto']['type'] != 'image/webp' &&
                    $_FILES['foto']['type'] != 'image/png') {
                    $error = "La foto no tiene el formato admitido, debe ser jpg, webp o png";
                } else {
                    $foto = generarNombreArchivo($_FILES['foto']['name']);
                    while (file_exists("web/fotosUsuarios/$foto")) {
                        $foto = generarNombreArchivo($_FILES['foto']['name']);
                    }
                    if (!move_uploaded_file($_FILES['foto']['tmp_name'], "web/fotosUsuarios/$foto")) {
                        die("Error al copiar la foto a la carpeta fotosUsuarios");
                    }
                }
                if ($error == '') {
                    $organizacion = new Organizacion();
                    $organizacion->setNombre($nombre);
                    $organizacion->setDescripcion($descripcion);
                    $organizacion->setSitioWeb($sitioWeb);
                    $organizacion->setTelefono($telefono);
                    $organizacion->setEmail($email);
                    $passwordCifrado = password_hash($password, PASSWORD_DEFAULT);
                    $organizacion->setPassword($passwordCifrado);
                    $organizacion->setDireccion($direccion);
                    $organizacion->setFoto($foto);
                    $organizacion->setCiego($ciego);
                    $organizacion->setRol($rol);
                    $organizacion->setSid(sha1(rand() + time()), true);
    
                    if ($organizacionesDAO->insert($organizacion)) {
                        header('location: index.php?accion=paginaPrincipal&accessibility=' . $_SESSION['accessibility']);
                        die();
                    } else {
                        $error = "No se ha podido insertar la organización";
                    }
                }
            }
        }
    
        require 'app/vistas/registrar.php';
    }
    
    

    public function loginOrganizacion() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Creamos la conexión utilizando la clase que hemos creado
            $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnexion();

            // Limpiamos los datos que vienen del usuario
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            // Validamos el usuario
            $organizacionesDAO = new OrganizacionesDAO($conn);
            if ($organizacion = $organizacionesDAO->getByEmail($email)) {
                if (password_verify($password, $organizacion->getPassword())) {

                    // Creamos la cookie para que nos recuerde 1 semana
                    setcookie('sid', $organizacion->getSid(), time() + 24 * 60 * 60, '/');
                    
                    // Redirigimos a paginaPrincipal.php con el parámetro de accesibilidad
                    require 'app/vistas/paginaPrincipal.php';
                }
            }
            // email o password incorrectos, redirigir a login.php con un mensaje de error
            guardarMensaje("Email o password incorrectos"); 
        }
        require 'app/vistas/login.php';
    }

    public function logout(){
        unset($_SESSION['email']);
        unset($_SESSION['idOrganizacion']);
        unset($_SESSION['foto']);
        unset($_SESSION['rol']);
        setcookie('sid','',0,'/');
        require 'app/vistas/paginaPrincipal.php';
    }

}
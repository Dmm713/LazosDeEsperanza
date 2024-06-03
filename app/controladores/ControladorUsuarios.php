<?php 

Class ControladorUsuarios{
    public function registrar() {
        $error = '';
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Limpiamos los datos
            $email = htmlentities($_POST['email']);
            $password = htmlentities($_POST['password']);
            $foto = '';
            $nombre = htmlentities($_POST['nombre']);
            $apellidos = htmlentities($_POST['apellidos']);
            $direccion = htmlentities($_POST['direccion']);
            $ciego = htmlentities($_POST['ciego']);
            $rol = htmlentities($_POST['rol']);
    
            // Validación y conexión con la BD
            $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnexion();
    
            $usuariosDAO = new UsuariosDAO($conn);
            if ($usuariosDAO->getByEmail($email) != null) {
                $error = "Ya hay un usuario con ese email";
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
                    $usuario = new Usuario();
                    $usuario->setNombre($nombre);
                    $usuario->setApellidos($apellidos);
                    $usuario->setDireccion($direccion);
                    $usuario->setCiego($ciego);
                    $usuario->setEmail($email);
                    $passwordCifrado = password_hash($password, PASSWORD_DEFAULT);
                    $usuario->setPassword($passwordCifrado);
                    $usuario->setRol($rol);
                    $usuario->setFoto($foto);
                    $usuario->setSid(sha1(rand() + time()), true);
    
                    if ($usuariosDAO->insert($usuario)) {
                        
                        header('location: index.php?accion=paginaPrincipal&accessibility=' . $_SESSION['accessibility']);
                        die();
                    } else {
                        $error = "No se ha podido insertar el usuario";
                    }
                }
            }
        }
    
        require 'app/vistas/registrar.php';
    }
    


    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Creamos la conexión utilizando la clase que hemos creado
            $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnexion();

            // Limpiamos los datos que vienen del usuario
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            // Validamos el usuario
            $usuariosDAO = new UsuariosDAO($conn);
            if ($usuario = $usuariosDAO->getByEmail($email)) {
                if (password_verify($password, $usuario->getPassword())) {
                    // email y password correctos. Iniciamos sesión
                   
                    // Creamos la cookie para que nos recuerde 1 semana
                    setcookie('sid', $usuario->getSid(), time() + 24 * 60 * 60, '/');
                    
                    // Redirigimos a paginaPrincipal.php con el parámetro de accesibilidad
                    header('location: index.php?accion=paginaPrincipal&accessibility=' . $_SESSION['accessibility']);
                    die();
                }
            }
            // email o password incorrectos, redirigir a login.php con un mensaje de error
            guardarMensaje("Email o password incorrectos");
            
        }

        require 'app/vistas/login.php';
    }

    public function logout(){
        unset($_SESSION['email']);
        unset($_SESSION['idUsuario']);
        unset($_SESSION['foto']);
        unset($_SESSION['rol']);
        setcookie('sid','',0,'/');
        header('location: index.php?accion=paginaPrincipal&accessibility=' . $_SESSION['accessibility']);
    }

    public function verTodosLosUsuarios(){
          // Conectar a la base de datos
          $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
          $conn = $connexionDB->getConnexion();

          $usuariosDAO = new UsuariosDAO($conn);
          $usuarios = $usuariosDAO->getAllUsuarios();
         
     //Incluyo la vista
     require 'app/vistas/todosLosUsuarios.php';
    }
}
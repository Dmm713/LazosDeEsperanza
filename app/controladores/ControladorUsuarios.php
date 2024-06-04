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
    
    public function borrarUsuario() {
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
    
        //Creamos el objeto UsuariosDAO para acceder a BBDD a través de este objeto
        $usuariosDAO = new UsuariosDAO($conn);
    
        //Obtener el id del usuario
        $idUsuario = htmlspecialchars($_GET['idUsuario']);
    
        // Borrar el usuario y obtener el nombre de la foto
        $foto = $usuariosDAO->borrarUsuario($idUsuario);
    
        // Si se borró el usuario, borrar la foto del servidor
        if ($foto) {
            $filePath = "web/fotosUsuarios/$foto";
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    
        // Redirigir a la lista de usuarios
        header('location: index.php?accion=verTodosLosUsuarios');
        die();
    }
    
    public function editarUsuario(){
        $error = '';
    
        //Conectamos con la BD
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
    
        //Obtengo el id del usuario que viene por GET
        $idUsuario = htmlspecialchars($_GET['idUsuario']);
        //Obtengo el usuario de la BD
        $usuariosDAO = new UsuariosDAO($conn);
        $usuario = $usuariosDAO->getById($idUsuario);
    
        // Guardar el nombre de la foto antigua
        $fotoAntigua = $usuario->getFoto();
    
        //Cuando se envíe el formulario actualizo el usuario en la BD
        if($_SERVER['REQUEST_METHOD']=='POST'){
            //Limpiamos los datos que vienen del usuario
            $nombre = htmlspecialchars($_POST['nombre']);
            $apellidos = htmlspecialchars($_POST['apellidos']);
            $direccion = htmlspecialchars($_POST['direccion']);
            $ciego = htmlspecialchars($_POST['ciego']);
            $rol = htmlspecialchars($_POST['rol']);
    
            //Validamos los datos
            if(empty($nombre) || empty($apellidos) || empty($direccion) || empty($ciego) || empty($rol)){
                $error = "Todos los campos son obligatorios";
            } else {
                $usuario->setNombre($nombre);
                $usuario->setApellidos($apellidos);
                $usuario->setDireccion($direccion);
                $usuario->setCiego($ciego);
                $usuario->setRol($rol);
    
                // Manejar la subida de la nueva foto
                if (!empty($_FILES['foto']['name'])) {
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
                        // Actualizar la foto solo si se ha subido una nueva
                        $usuario->setFoto($foto);
                    }
                }
    
                if ($error == '') {
                    if ($usuariosDAO->update($usuario)) {
                        // Borrar la foto antigua si se subió una nueva
                        if (!empty($_FILES['foto']['name']) && $fotoAntigua && $usuario->getFoto() !== $fotoAntigua) {
                            unlink("web/fotosUsuarios/$fotoAntigua");
                        }
                        header('location: index.php?accion=verTodosLosUsuarios');
                        die();
                    } else {
                        $error = "No se ha podido actualizar el usuario";
                    }
                }
            }
        }
        require 'app/vistas/editarUsuario.php';
    }
    
    
    

    public function subirFotoAjax() {
        $response = ['error' => '', 'foto' => ''];
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_FILES['foto'])) {
                if ($_FILES['foto']['type'] != 'image/jpeg' &&
                    $_FILES['foto']['type'] != 'image/webp' &&
                    $_FILES['foto']['type'] != 'image/png') {
                    $response['error'] = "La foto no tiene el formato admitido, debe ser jpg, webp o png";
                } else {
                    $foto = generarNombreArchivo($_FILES['foto']['name']);
                    while (file_exists("web/fotosUsuarios/$foto")) {
                        $foto = generarNombreArchivo($_FILES['foto']['name']);
                    }
                    if (!move_uploaded_file($_FILES['foto']['tmp_name'], "web/fotosUsuarios/$foto")) {
                        $response['error'] = "Error al copiar la foto a la carpeta fotosUsuarios";
                    } else {
                        $response['foto'] = $foto;
                    }
                }
            } else {
                $response['error'] = "No se ha recibido ninguna foto";
            }
        }
    
        echo json_encode($response);
        die();
    }
    
 

    public function insertarUsuario(){
        
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
                        
                        header('location: index.php?accion=verTodosLosUsuarios');
                        die();
                    } else {
                        $error = "No se ha podido insertar el usuario";
                    }
                }
            }
        }
    
        require 'app/vistas/insertarUsuario.php';
    }
}
<?php 

Class ControladorUsuarios {
    public function registrar() {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = htmlentities($_POST['email']);
            $password = htmlentities($_POST['password']);
            $foto = '';
            $nombre = htmlentities($_POST['nombre']);
            $apellidos = htmlentities($_POST['apellidos']);
            $direccion = htmlentities($_POST['direccion']);
            $ciego = htmlentities($_POST['ciego']);
            $rol = htmlentities($_POST['rol']);

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
            $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnexion();
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $usuariosDAO = new UsuariosDAO($conn);
            if ($usuario = $usuariosDAO->getByEmail($email)) {
                if (password_verify($password, $usuario->getPassword())) {
                    setcookie('sid', $usuario->getSid(), time() + 24 * 60 * 60, '/');
                    header('location: index.php?accion=paginaPrincipal&accessibility=' . $_SESSION['accessibility']);
                    die();
                }
            }
            guardarMensaje("Email o password incorrectos");
        }
        require 'app/vistas/login.php';
    }

    public function logout() {
        unset($_SESSION['email']);
        unset($_SESSION['idUsuario']);
        unset($_SESSION['foto']);
        unset($_SESSION['rol']);
        setcookie('sid','',0,'/');
        header('location: index.php?accion=paginaPrincipal&accessibility=' . $_SESSION['accessibility']);
    }

    public function miPerfilUsuario($idUsuario) {
        // Conectar a la base de datos
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
    
        $usuariosDAO = new UsuariosDAO($conn);
        $usuario = $usuariosDAO->getUsuarioById($idUsuario);
    
        // Incluir la vista y pasar la organización
        require 'app/vistas/miPerfilUsuario.php';
    
        }

    public function verTodosLosUsuarios() {
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
        $usuariosDAO = new UsuariosDAO($conn);
        $usuarios = $usuariosDAO->getAllUsuarios();
        require 'app/vistas/todosLosUsuarios.php';
    }

    public function borrarUsuario() {
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
        $usuariosDAO = new UsuariosDAO($conn);
        $idUsuario = htmlspecialchars($_GET['idUsuario']);
        $foto = $usuariosDAO->borrarUsuario($idUsuario);
        if ($foto) {
            $filePath = "web/fotosUsuarios/$foto";
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        header('location: index.php?accion=verTodosLosUsuarios');
        die();
    }

    public function editarUsuario() {
        $error = '';
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
        $idUsuario = htmlspecialchars($_GET['idUsuario']);
        $usuariosDAO = new UsuariosDAO($conn);
        $usuario = $usuariosDAO->getById($idUsuario);
        $fotoAntigua = $usuario->getFoto();

        if($_SERVER['REQUEST_METHOD']=='POST') {
            $nombre = htmlspecialchars($_POST['nombre']);
            $apellidos = htmlspecialchars($_POST['apellidos']);
            $direccion = htmlspecialchars($_POST['direccion']);
            $ciego = htmlspecialchars($_POST['ciego']);
            $rol = htmlspecialchars($_POST['rol']);
            $fotoTemporal = htmlspecialchars($_POST['fotoTemporal']);

            if(empty($nombre) || empty($apellidos) || empty($direccion) || empty($ciego) || empty($rol)){
                $error = "Todos los campos son obligatorios";
            } else {
                $usuario->setNombre($nombre);
                $usuario->setApellidos($apellidos);
                $usuario->setDireccion($direccion);
                $usuario->setCiego($ciego);
                $usuario->setRol($rol);

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
                        $usuario->setFoto($foto);
                    }
                } elseif (!empty($fotoTemporal)) {
                    $foto = str_replace("temp_", "", $fotoTemporal);
                    rename("web/fotosUsuarios/$fotoTemporal", "web/fotosUsuarios/$foto");
                    $usuario->setFoto($foto);
                }

                if ($error == '') {
                    if ($usuariosDAO->update($usuario)) {
                        if (!empty($_FILES['foto']['name']) && $fotoAntigua && $usuario->getFoto() !== $fotoAntigua) {
                            unlink("web/fotosUsuarios/$fotoAntigua");
                        }
                        if (!empty($fotoTemporal) && file_exists("web/fotosUsuarios/$fotoTemporal")) {
                            unlink("web/fotosUsuarios/$fotoTemporal");
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

    public function editarMiPerfilUsuario() {
        $error = '';
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
        $idUsuario = htmlspecialchars($_GET['idUsuario']);
        $usuariosDAO = new UsuariosDAO($conn);
        $usuario = $usuariosDAO->getUsuarioById($idUsuario);
        $fotoAntigua = $usuario->getFoto();
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = htmlspecialchars($_POST['nombre']);
            $apellidos = htmlspecialchars($_POST['apellidos']);
            $direccion = htmlspecialchars($_POST['direccion']);
            $ciego = htmlspecialchars($_POST['ciego']);
            $rol = htmlspecialchars($_POST['rol']);
            $fotoTemporal = htmlspecialchars($_POST['fotoTemporal']);
    
            if (empty($nombre) || empty($apellidos) || empty($direccion) || empty($ciego) || empty($rol)) {
                $error = "Todos los campos son obligatorios";
            } else {
                $usuario->setNombre($nombre);
                $usuario->setApellidos($apellidos);
                $usuario->setDireccion($direccion);
                $usuario->setCiego($ciego);
                $usuario->setRol($rol);
    
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
                        $usuario->setFoto($foto);
                    }
                } elseif (!empty($fotoTemporal)) {
                    $foto = str_replace("temp_", "", $fotoTemporal);
                    rename("web/fotosUsuarios/$fotoTemporal", "web/fotosUsuarios/$foto");
                    $usuario->setFoto($foto);
                }
    
                if ($error == '') {
                    if ($usuariosDAO->update($usuario)) {
                        if (!empty($_FILES['foto']['name']) && $fotoAntigua && $usuario->getFoto() !== $fotoAntigua) {
                            unlink("web/fotosUsuarios/$fotoAntigua");
                        }
                        if (!empty($fotoTemporal) && file_exists("web/fotosUsuarios/$fotoTemporal")) {
                            unlink("web/fotosUsuarios/$fotoTemporal");
                        }
                        header('location: index.php?accion=miPerfilUsuario');
                        die();
                    } else {
                        $error = "No se ha podido actualizar el usuario";
                    }
                }
            }
        }
        require 'app/vistas/editarMiPerfilUsuario.php';
    }


    public function subirFotoAjax() {
        $response = ['success' => false, 'error' => '', 'foto' => ''];
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idUsuario = htmlspecialchars($_GET['idUsuario']);
            $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnexion();
            $usuariosDAO = new UsuariosDAO($conn);
    
            if (isset($_FILES['nuevaFoto'])) {
                if ($_FILES['nuevaFoto']['type'] != 'image/jpeg' &&
                    $_FILES['nuevaFoto']['type'] != 'image/webp' &&
                    $_FILES['nuevaFoto']['type'] != 'image/png') {
                    $response['error'] = "La foto no tiene el formato admitido, debe ser jpg, webp o png";
                } else {
                    $foto = generarNombreArchivo($_FILES['nuevaFoto']['name']);
                    while (file_exists("web/fotosUsuarios/$foto")) {
                        $foto = generarNombreArchivo($_FILES['nuevaFoto']['name']);
                    }
                    if (!move_uploaded_file($_FILES['nuevaFoto']['tmp_name'], "web/fotosUsuarios/$foto")) {
                        $response['error'] = "Error al copiar la foto a la carpeta fotosUsuarios";
                    } else {
                        // Actualizar la base de datos
                        $usuario = $usuariosDAO->getById($idUsuario);
                        $fotoAntigua = $usuario->getFoto();
                        $usuario->setFoto($foto);
    
                        if ($usuariosDAO->update($usuario)) {
                            // Eliminar la foto anterior si existe
                            if ($fotoAntigua && file_exists("web/fotosUsuarios/$fotoAntigua")) {
                                unlink("web/fotosUsuarios/$fotoAntigua");
                            }
                            $response['foto'] = $foto;
                            $response['success'] = true;
                        } else {
                            $response['error'] = "Error al actualizar la foto en la base de datos";
                        }
                    }
                }
            } else {
                $response['error'] = "No se ha recibido ninguna foto";
            }
        }
        echo json_encode($response);
        die();
    }
    
    
    
    
    

    public function insertarUsuario() {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = htmlentities($_POST['email']);
            $password = htmlentities($_POST['password']);
            $foto = '';
            $nombre = htmlentities($_POST['nombre']);
            $apellidos = htmlentities($_POST['apellidos']);
            $direccion = htmlentities($_POST['direccion']);
            $ciego = htmlentities($_POST['ciego']);
            $rol = htmlentities($_POST['rol']);

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
    public function misVoluntariados() {
        // Verificar si el usuario está autenticado y obtener su idUsuario
        if (!isset($_SESSION['idUsuario'])) {
            header('location: index.php?accion=login');
            die();
        }
        
        $idUsuario = $_SESSION['idUsuario'];
        
        // Conectar a la base de datos
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
        
        // Obtener la lista de voluntariados del usuario con detalles del proyecto
        $voluntariosDAO = new VoluntariosDAO($conn);
        $voluntariados = $voluntariosDAO->getVoluntariadosByUsuarioWithProjectDetails($idUsuario);
        
        // Incluir la vista y pasar los voluntariados
        require 'app/vistas/misVoluntariados.php';
    }
     
    public function borrarMisVoluntariados() {
        if (!isset($_SESSION['idUsuario'])) {
            echo "ID de usuario no encontrado en la sesión.";
            return;
        }
    
        // Obtener el idVoluntario de la solicitud GET
        $idVoluntario = htmlspecialchars($_GET['idVoluntario']);
        
        // Conectar a la base de datos
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
        
        // Verificar que el voluntariado pertenece al usuario
        $voluntariosDAO = new VoluntariosDAO($conn);
        $voluntario = $voluntariosDAO->getByIdVoluntario($idVoluntario);
        if ($voluntario->getIdUsuario() !== $_SESSION['idUsuario']) {
            echo "No tienes permiso para borrar este voluntariado.";
            return;
        }
        
        // Borrar el voluntario
        $borrado = $voluntariosDAO->borrarVoluntario($idVoluntario);
        
        if ($borrado) {
            header('location: index.php?accion=verMisVoluntariados');
        } else {
            echo "No se pudo borrar el voluntariado.";
        }
        die();
    }
    
    

}
?>

<?php

class ControladorOrganizaciones
{
    public function registrarOrganizacion()
    {
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
                if (
                    $_FILES['foto']['type'] != 'image/jpeg' &&
                    $_FILES['foto']['type'] != 'image/webp' &&
                    $_FILES['foto']['type'] != 'image/png'
                ) {
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



    public function loginOrganizacion()
    {
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
                    header('location: index.php?accion=paginaPrincipal&accessibility=' . $_SESSION['accessibility']);
                    die();
                }
            }
            // email o password incorrectos, redirigir a login.php con un mensaje de error
            guardarMensaje("Email o password incorrectos");
        }
        require 'app/vistas/login.php';
    }

    public function logout()
    {
        unset($_SESSION['email']);
        unset($_SESSION['idOrganizacion']);
        unset($_SESSION['foto']);
        unset($_SESSION['rol']);
        setcookie('sid', '', 0, '/');
        require 'app/vistas/paginaPrincipal.php';
    }



    public function verTodasLasOrganizaciones()
    {
        // Conectar a la base de datos
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        $organizacionesDAO = new OrganizacionesDAO($conn);
        $organizaciones = $organizacionesDAO->getAllOrganizaciones();

        //Incluyo la vista
        require 'app/vistas/todasLasOrganizaciones.php';
    }

    public function borrarOrganizacion()
    {
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        //Creamos el objeto OrganizacionesDAO para acceder a BBDD a través de este objeto
        $organizacionesDAO = new OrganizacionesDAO($conn);

        //Obtener el id del usuario
        $idOrganizacion = htmlspecialchars($_GET['idOrganizacion']);

        // Borrar el usuario y obtener el nombre de la foto
        $foto = $organizacionesDAO->borrarOrganizacion($idOrganizacion);

        // Si se borró el usuario, borrar la foto del servidor
        if ($foto) {
            $filePath = "web/fotosUsuarios/$foto";
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Redirigir a la lista de usuarios
        header('location: index.php?accion=verTodasLasOrganizaciones');
        die();
    }

    public function editarOrganizacion()
    {
        $error = '';

        //Conectamos con la BD
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        //Obtengo el id del usuario que viene por GET
        $idOrganizacion = htmlspecialchars($_GET['idOrganizacion']);
        //Obtengo el usuario de la BD
        $organizacionesDAO = new OrganizacionesDAO($conn);
        $organizacion = $organizacionesDAO->getById($idOrganizacion);

        // Guardar el nombre de la foto antigua
        $fotoAntigua = $organizacion->getFoto();

        //Cuando se envíe el formulario actualizo el usuario en la BD
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Limpiamos los datos que vienen del usuario
            $nombre = htmlspecialchars($_POST['nombre']);
            $descripcion = htmlspecialchars($_POST['descripcion']);
            $sitioWeb = htmlspecialchars($_POST['sitioWeb']);
            $telefono = htmlspecialchars($_POST['telefono']);
            $direccion = htmlspecialchars($_POST['direccion']);
            $ciego = htmlspecialchars($_POST['ciego']);
            $rol = htmlspecialchars($_POST['rol']);
            $fotoTemporal = htmlspecialchars($_POST['fotoTemporal']);

            //Validamos los datos
            if (empty($nombre) || empty($descripcion) || empty($sitioWeb) || empty($telefono) || empty($direccion) || empty($ciego) || empty($rol)) {
                $error = "Todos los campos son obligatorios";
            } else {
                $organizacion->setNombre($nombre);
                $organizacion->setDescripcion($descripcion);
                $organizacion->setSitioWeb($sitioWeb);
                $organizacion->setTelefono($telefono);
                $organizacion->setDireccion($direccion);
                $organizacion->setCiego($ciego);
                $organizacion->setRol($rol);

                // Manejar la subida de la nueva foto
                if (!empty($_FILES['foto']['name'])) {
                    if (
                        $_FILES['foto']['type'] != 'image/jpeg' &&
                        $_FILES['foto']['type'] != 'image/webp' &&
                        $_FILES['foto']['type'] != 'image/png'
                    ) {
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
                        $organizacion->setFoto($foto);
                    }
                } elseif (!empty($fotoTemporal)) {
                    // Si no se subió una nueva foto pero hay una foto temporal
                    $foto = str_replace("temp_", "", $fotoTemporal); // Renombrar foto temporal a definitiva
                    rename("web/fotosUsuarios/$fotoTemporal", "web/fotosUsuarios/$foto");
                    $organizacion->setFoto($foto);
                }

                if ($error == '') {
                    if ($organizacionesDAO->update($organizacion)) {
                        // Borrar la foto antigua si se subió una nueva
                        if (!empty($_FILES['foto']['name']) && $fotoAntigua && $organizacion->getFoto() !== $fotoAntigua) {
                            unlink("web/fotosUsuarios/$fotoAntigua");
                        }

                        // Borrar cualquier foto temporal remanente
                        if (!empty($fotoTemporal) && file_exists("web/fotosUsuarios/$fotoTemporal")) {
                            unlink("web/fotosUsuarios/$fotoTemporal");
                        }

                        header('location: index.php?accion=verTodasLasOrganizaciones');
                        die();
                    } else {
                        $error = "No se ha podido actualizar la organización";
                    }
                }
            }
        }
        require 'app/vistas/editarOrganizacion.php';
    }






    public function subirFotoAjax()
    {
        $response = ['error' => '', 'foto' => ''];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_FILES['foto'])) {
                if (
                    $_FILES['foto']['type'] != 'image/jpeg' &&
                    $_FILES['foto']['type'] != 'image/webp' &&
                    $_FILES['foto']['type'] != 'image/png'
                ) {
                    $response['error'] = "La foto no tiene el formato admitido, debe ser jpg, webp o png";
                } else {
                    $foto = "temp_" . generarNombreArchivo($_FILES['foto']['name']);
                    while (file_exists("web/fotosUsuarios/$foto")) {
                        $foto = "temp_" . generarNombreArchivo($_FILES['foto']['name']);
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




    public function insertarOrganizacion()
    {

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
                if (
                    $_FILES['foto']['type'] != 'image/jpeg' &&
                    $_FILES['foto']['type'] != 'image/webp' &&
                    $_FILES['foto']['type'] != 'image/png'
                ) {
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

        require 'app/vistas/insertarOrganizacion.php';
    }



    public function misEventosOrganizacion(){
         // Verificar si el idOrganizacion está en la sesión
    if (!isset($_SESSION['idOrganizacion'])) {
        echo "ID de organización no encontrado en la sesión.";
        return;
    }

    // Verificar si el rol del usuario es 'Organizacion'
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Organizacion') {
        echo "Acceso denegado. Rol insuficiente.";
        return;
    }

    // Obtener el idOrganizacion de la sesión
    $idOrganizacion = $_SESSION['idOrganizacion'];

    // Conectar a la base de datos
    $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
    $conn = $connexionDB->getConnexion();

    // Obtener la organización seleccionada por el ID
    $organizacionesDAO = new OrganizacionesDAO($conn);
    $organizacion = $organizacionesDAO->getById($idOrganizacion);

    // Verificar si la organización existe
    if (!$organizacion) {
        // Manejar el caso donde la organización no existe
        echo "Organización no encontrada.";
        return;
    }

    // Obtener todos los usuarios
    $usuariosDAO = new UsuariosDAO($conn);
    $usuarios = $usuariosDAO->getAllUsuarios();

    // Obtener todos los eventos de la organización
    $eventosDAO = new EventosDAO($conn);
    $eventos = $eventosDAO->getEventosByOrganizacion($idOrganizacion);

    // Incluir la vista y pasar los datos necesarios
    require 'app/vistas/misEventos.php';
    }

    public function crearEvento(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Verificar si el idOrganizacion está en la sesión
            if (!isset($_SESSION['idOrganizacion'])) {
                echo "ID de organización no encontrado en la sesión.";
                return;
            }

            // Obtener el idOrganizacion de la sesión
            $idOrganizacion = $_SESSION['idOrganizacion'];

            // Conectar a la base de datos
            $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnexion();

            // Obtener los datos del formulario
            $titulo = htmlspecialchars($_POST['titulo']);
            $descripcion = htmlspecialchars($_POST['descripcion']);
            $fechaEvento = htmlspecialchars($_POST['fechaEvento']);
            $ubicacion = htmlspecialchars($_POST['ubicacion']);
            $fotoEvento = '';

            // Manejar la subida de la foto del evento
            if (!empty($_FILES['fotoEvento']['name'])) {
                if (
                    $_FILES['fotoEvento']['type'] != 'image/jpeg' &&
                    $_FILES['fotoEvento']['type'] != 'image/webp' &&
                    $_FILES['fotoEvento']['type'] != 'image/png'
                ) {
                    echo "La foto no tiene el formato admitido, debe ser jpg, webp o png";
                    return;
                } else {
                    $fotoEvento = generarNombreArchivo($_FILES['fotoEvento']['name']);
                    while (file_exists("web/fotosEventos/$fotoEvento")) {
                        $fotoEvento = generarNombreArchivo($_FILES['fotoEvento']['name']);
                    }
                    if (!move_uploaded_file($_FILES['fotoEvento']['tmp_name'], "web/fotosEventos/$fotoEvento")) {
                        die("Error al copiar la foto a la carpeta fotosEventos");
                    }
                }
            }

            // Crear el objeto Evento y guardarlo en la base de datos
            $evento = new Evento();
            $evento->setIdOrganizacion($idOrganizacion);
            $evento->setTitulo($titulo);
            $evento->setDescripcion($descripcion);
            $evento->setFechaEvento($fechaEvento);
            $evento->setUbicacion($ubicacion);
            $evento->setFotoEvento($fotoEvento);

            $eventosDAO = new EventosDAO($conn);
            if ($eventosDAO->insert($evento)) {
                header('location: index.php?accion=misEventosOrganizacion');
                die();
            } else {
                echo "No se ha podido crear el evento.";
            }
        } else {
            // Mostrar el formulario de creación de eventos
            require 'app/vistas/nuevoEvento.php';
        }
    }

    public function editarEvento() {
        $error = '';

        // Conectamos con la BD
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
    
        // Obtengo el id del evento que viene por GET
        $idEvento = htmlspecialchars($_GET['idEvento']);
        // Obtengo el evento de la BD
        $eventosDAO = new EventosDAO($conn);
        $evento = $eventosDAO->getById($idEvento);
    
        // Guardar el nombre de la foto antigua
        $fotoAntigua = $evento->getFotoEvento();
    
        // Cuando se envíe el formulario, actualizo el evento en la BD
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Limpiamos los datos que vienen del usuario
            $titulo = htmlspecialchars($_POST['titulo']);
            $descripcion = htmlspecialchars($_POST['descripcion']);
            $fechaEvento = htmlspecialchars($_POST['fechaEvento']);
            $ubicacion = htmlspecialchars($_POST['ubicacion']);
            $fotoTemporal = htmlspecialchars($_POST['fotoTemporal']);
    
            // Validamos los datos
            if (empty($titulo) || empty($descripcion) || empty($fechaEvento) || empty($ubicacion)) {
                $error = "Todos los campos son obligatorios";
            } else {
                $evento->setTitulo($titulo);
                $evento->setDescripcion($descripcion);
                $evento->setFechaEvento($fechaEvento);
                $evento->setUbicacion($ubicacion);
    
                // Manejar la subida de la nueva foto
                if (!empty($_FILES['fotoEvento']['name'])) {
                    if (
                        $_FILES['fotoEvento']['type'] != 'image/jpeg' &&
                        $_FILES['fotoEvento']['type'] != 'image/webp' &&
                        $_FILES['fotoEvento']['type'] != 'image/png'
                    ) {
                        $error = "La foto no tiene el formato admitido, debe ser jpg, webp o png";
                    } else {
                        $extension = pathinfo($_FILES['fotoEvento']['name'], PATHINFO_EXTENSION);
                        $fotoEvento = hash('sha256', uniqid()) . '.' . $extension;
    
                        if (!move_uploaded_file($_FILES['fotoEvento']['tmp_name'], "web/fotosEventos/$fotoEvento")) {
                            die("Error al copiar la foto a la carpeta fotosEventos");
                        }
                        // Actualizar la foto solo si se ha subido una nueva
                        $evento->setFotoEvento($fotoEvento);
                    }
                } elseif (!empty($fotoTemporal)) {
                    // Si no se subió una nueva foto pero hay una foto temporal
                    $fotoEvento = str_replace("temp_", "", $fotoTemporal); // Renombrar foto temporal a definitiva
                    rename("web/fotosEventos/$fotoTemporal", "web/fotosEventos/$fotoEvento");
                    $evento->setFotoEvento($fotoEvento);
                } else {
                    // Si no se subió una nueva foto y no hay foto temporal, mantener la foto antigua
                    $evento->setFotoEvento($fotoAntigua);
                }
    
                if ($error == '') {
                    if ($eventosDAO->update($evento)) {
                        // Borrar la foto antigua si se subió una nueva
                        if (!empty($_FILES['fotoEvento']['name']) && $fotoAntigua && $evento->getFotoEvento() !== $fotoAntigua) {
                            unlink("web/fotosEventos/$fotoAntigua");
                        }
    
                        // Borrar cualquier foto temporal remanente
                        if (!empty($fotoTemporal) && file_exists("web/fotosEventos/$fotoTemporal")) {
                            unlink("web/fotosEventos/$fotoTemporal");
                        }
    
                        header('location: index.php?accion=misEventosOrganizacion');
                        die();
                    } else {
                        $error = "No se ha podido actualizar el evento";
                    }
                }
            }
        }
        require 'app/vistas/editarEvento.php';
    }
    

    public function borrarEvento() {
          // Verificar si el idOrganizacion está en la sesión
    if (!isset($_SESSION['idOrganizacion'])) {
        echo "ID de organización no encontrado en la sesión.";
        return;
    }

    // Obtener el idOrganizacion de la sesión
    $idOrganizacion = $_SESSION['idOrganizacion'];
    $idEvento = $_GET['idEvento'];

    // Conectar a la base de datos
    $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
    $conn = $connexionDB->getConnexion();

    // Eliminar el evento
    $eventosDAO = new EventosDAO($conn);
    $fotoEvento = $eventosDAO->delete($idEvento);

    if ($fotoEvento) {
        // Si se eliminó el evento, borrar la foto del servidor
        $filePath = "web/fotosEventos/$fotoEvento";
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    header('location: index.php?accion=misEventosOrganizacion');
    die();
    }
}

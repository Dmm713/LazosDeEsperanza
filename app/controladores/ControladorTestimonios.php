<?php

class ControladorTestimonios{
    public function misTestimoniosOrganizacion(){
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
        $organizacion = $organizacionesDAO->getOrganizacionById($idOrganizacion);

        // Verificar si la organización existe
        if (!$organizacion) {
            echo "Organización no encontrada.";
            return;
        }

        // Obtener todos los usuarios
        $usuariosDAO = new UsuariosDAO($conn);
        $usuarios = $usuariosDAO->getAllUsuarios();

        // Obtener todos los testimonios de la organización
        $testimoniosDAO = new TestimoniosDAO($conn);
        $testimonios = $testimoniosDAO->getTestimoniosByOrganizacion($idOrganizacion);

        // Incluir la vista y pasar los datos necesarios
        require 'app/vistas/misTestimonios.php';
    }

    public function crearTestimonio(){
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
            $nombre = htmlspecialchars($_POST['nombre']);
            $apellidos = htmlspecialchars($_POST['apellidos']);
            $problema = htmlspecialchars($_POST['problema']);
            $solucion = htmlspecialchars($_POST['solucion']);
            $foto = '';

            // Manejar la subida de la foto del testimonio
            if (!empty($_FILES['foto']['name'])) {
                if (
                    $_FILES['foto']['type'] != 'image/jpeg' &&
                    $_FILES['foto']['type'] != 'image/webp' &&
                    $_FILES['foto']['type'] != 'image/png'
                ) {
                    echo "La foto no tiene el formato admitido, debe ser jpg, webp o png";
                    return;
                } else {
                    $foto = generarNombreArchivo($_FILES['foto']['name']);
                    while (file_exists("web/fotosTestimonios/$foto")) {
                        $foto = generarNombreArchivo($_FILES['foto']['name']);
                    }
                    if (!move_uploaded_file($_FILES['foto']['tmp_name'], "web/fotosTestimonios/$foto")) {
                        die("Error al copiar la foto a la carpeta fotosTestimonios");
                    }
                }
            }

            // Crear el objeto Testimonio y guardarlo en la base de datos
            $testimonio = new Testimonio();
            $testimonio->setIdOrganizacion($idOrganizacion);
            $testimonio->setNombre($nombre);
            $testimonio->setApellidos($apellidos);
            $testimonio->setProblema($problema);
            $testimonio->setSolucion($solucion);
            $testimonio->setFoto($foto);

            $testimoniosDAO = new TestimoniosDAO($conn);
            if ($testimoniosDAO->insertTestimonio($testimonio)) {
                header('location: index.php?accion=misTestimoniosOrganizacion');
                die();
            } else {
                echo "No se ha podido crear el testimonio.";
            }
        } else {
            // Mostrar el formulario de creación de testimonios
            require 'app/vistas/crearTestimonio.php';
        }
    }

    public function editarTestimonio() {
        $error = '';

        // Conectamos con la BD
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        // Obtengo el id del testimonio que viene por GET
        $idTestimonio = htmlspecialchars($_GET['idTestimonio']);
        // Obtengo el testimonio de la BD
        $testimoniosDAO = new TestimoniosDAO($conn);
        $testimonio = $testimoniosDAO->getTestimonioById($idTestimonio);

        // Guardar el nombre de la foto antigua
        $fotoAntigua = $testimonio->getFoto();

        // Cuando se envíe el formulario, actualizo el testimonio en la BD
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Limpiamos los datos que vienen del usuario
            $nombre = htmlspecialchars($_POST['nombre']);
            $apellidos = htmlspecialchars($_POST['apellidos']);
            $problema = htmlspecialchars($_POST['problema']);
            $solucion = htmlspecialchars($_POST['solucion']);
            $fotoTemporal = isset($_POST['fotoTemporal']) ? htmlspecialchars($_POST['fotoTemporal']) : '';

            // Validamos los datos
            if (empty($nombre) || empty($apellidos) || empty($problema) || empty($solucion)) {
                $error = "Todos los campos son obligatorios";
            } else {
                $testimonio->setNombre($nombre);
                $testimonio->setApellidos($apellidos);
                $testimonio->setProblema($problema);
                $testimonio->setSolucion($solucion);

                // Manejar la subida de la nueva foto
                if (!empty($_FILES['foto']['name'])) {
                    if (
                        $_FILES['foto']['type'] != 'image/jpeg' &&
                        $_FILES['foto']['type'] != 'image/webp' &&
                        $_FILES['foto']['type'] != 'image/png'
                    ) {
                        $error = "La foto no tiene el formato admitido, debe ser jpg, webp o png";
                    } else {
                        $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                        $foto = hash('sha256', uniqid()) . '.' . $extension;

                        if (!move_uploaded_file($_FILES['foto']['tmp_name'], "web/fotosTestimonios/$foto")) {
                            die("Error al copiar la foto a la carpeta fotosTestimonios");
                        }
                        // Actualizar la foto solo si se ha subido una nueva
                        $testimonio->setFoto($foto);
                    }
                } elseif (!empty($fotoTemporal)) {
                    // Si no se subió una nueva foto pero hay una foto temporal
                    $foto = str_replace("temp_", "", $fotoTemporal); // Renombrar foto temporal a definitiva
                    rename("web/fotosTestimonios/$fotoTemporal", "web/fotosTestimonios/$foto");
                    $testimonio->setFoto($foto);
                } else {
                    // Si no se subió una nueva foto y no hay foto temporal, mantener la foto antigua
                    $testimonio->setFoto($fotoAntigua);
                }

                if ($error == '') {
                    if ($testimoniosDAO->updateTestimonio($testimonio)) {
                        // Borrar la foto antigua si se subió una nueva
                        if (!empty($_FILES['foto']['name']) && $fotoAntigua && $testimonio->getFoto() !== $fotoAntigua) {
                            unlink("web/fotosTestimonios/$fotoAntigua");
                        }

                        // Borrar cualquier foto temporal remanente
                        if (!empty($fotoTemporal) && file_exists("web/fotosTestimonios/$fotoTemporal")) {
                            unlink("web/fotosTestimonios/$fotoTemporal");
                        }

                        header('location: index.php?accion=misTestimoniosOrganizacion');
                        die();
                    } else {
                        $error = "No se ha podido actualizar el testimonio";
                    }
                }
            }
        }
        require 'app/vistas/editarTestimonio.php';
    }

    public function borrarTestimonio() {
        // Verificar si el idOrganizacion está en la sesión
        if (!isset($_SESSION['idOrganizacion'])) {
            echo "ID de organización no encontrado en la sesión.";
            return;
        }

        // Obtener el idOrganizacion de la sesión
        $idOrganizacion = $_SESSION['idOrganizacion'];
        $idTestimonio = $_GET['idTestimonio'];

        // Conectar a la base de datos
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        // Eliminar el testimonio
        $testimoniosDAO = new TestimoniosDAO($conn);
        $foto = $testimoniosDAO->deleteTestimonio($idTestimonio);

        if ($foto) {
            // Si se eliminó el testimonio, borrar la foto del servidor
            $filePath = "web/fotosTestimonios/$foto";
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        header('location: index.php?accion=misTestimoniosOrganizacion');
        die();
    }
}
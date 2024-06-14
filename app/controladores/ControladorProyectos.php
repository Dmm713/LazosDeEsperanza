<?php

class ControladorProyectos{

    public function misProyectosOrganizacion(){
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
       // Manejar el caso donde la organización no existe
       echo "Organización no encontrada.";
       return;
   }

   // Obtener todos los usuarios
   $usuariosDAO = new UsuariosDAO($conn);
   $usuarios = $usuariosDAO->getAllUsuarios();

   // Obtener todos los eventos de la organización
   $proyectosDAO = new ProyectosDAO($conn);
   $proyectos = $proyectosDAO->getProyectosByOrganizacion($idOrganizacion);

   // Incluir la vista y pasar los datos necesarios
   require 'app/vistas/misProyectos.php';
   }

   public function crearProyecto(){
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
        $fechaInicio = htmlspecialchars($_POST['fechaInicio']);
        $fechaFin = htmlspecialchars($_POST['fechaFin']);
        $objetivoFinanciero = htmlspecialchars($_POST['objetivoFinanciero']);
        $fotoProyecto = '';

        // Manejar la subida de la foto del proyecto
        if (!empty($_FILES['fotoProyecto']['name'])) {
            if (
                $_FILES['fotoProyecto']['type'] != 'image/jpeg' &&
                $_FILES['fotoProyecto']['type'] != 'image/webp' &&
                $_FILES['fotoProyecto']['type'] != 'image/png'
            ) {
                echo "La foto no tiene el formato admitido, debe ser jpg, webp o png";
                return;
            } else {
                $fotoProyecto = generarNombreArchivo($_FILES['fotoProyecto']['name']);
                while (file_exists("web/fotosProyectos/$fotoProyecto")) {
                    $fotoProyecto = generarNombreArchivo($_FILES['fotoProyecto']['name']);
                }
                if (!move_uploaded_file($_FILES['fotoProyecto']['tmp_name'], "web/fotosProyectos/$fotoProyecto")) {
                    die("Error al copiar la foto a la carpeta fotosProyectos");
                }
            }
        }

        // Crear el objeto Proyecto y guardarlo en la base de datos
        $proyecto = new Proyecto();
        $proyecto->setIdOrganizacion($idOrganizacion);
        $proyecto->setTitulo($titulo);
        $proyecto->setDescripcion($descripcion);
        $proyecto->setFechaInicio($fechaInicio);
        $proyecto->setFechaFin($fechaFin);
        $proyecto->setObjetivoFinanciero($objetivoFinanciero);
        $proyecto->setFotoProyecto($fotoProyecto);

        $proyectosDAO = new ProyectosDAO($conn);
        if ($proyectosDAO->insert($proyecto)) {
            header('location: index.php?accion=misProyectosOrganizacion');
            die();
        } else {
            echo "No se ha podido crear el proyecto.";
        }
    } else {
        // Mostrar el formulario de creación de proyectos
        require 'app/vistas/crearProyecto.php';
    }
}

public function editarProyecto() {
    $error = '';

    // Conectamos con la BD
    $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
    $conn = $connexionDB->getConnexion();

    // Obtengo el id del proyecto que viene por GET
    $idProyecto = htmlspecialchars($_GET['idProyecto']);
    // Obtengo el proyecto de la BD
    $proyectosDAO = new ProyectosDAO($conn);
    $proyecto = $proyectosDAO->getById($idProyecto);

    // Guardar el nombre de la foto antigua
    $fotoAntigua = $proyecto->getFotoProyecto();

    // Cuando se envíe el formulario, actualizo el proyecto en la BD
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Limpiamos los datos que vienen del usuario
        $titulo = htmlspecialchars($_POST['titulo']);
        $descripcion = htmlspecialchars($_POST['descripcion']);
        $fechaInicio = date('Y-m-d', strtotime(htmlspecialchars($_POST['fechaInicio'])));
        $fechaFin = date('Y-m-d', strtotime(htmlspecialchars($_POST['fechaFin'])));
        $objetivoFinanciero = htmlspecialchars($_POST['objetivoFinanciero']);
        $fotoTemporal = isset($_POST['fotoTemporal']) ? htmlspecialchars($_POST['fotoTemporal']) : '';

        // Validamos los datos
        if (empty($titulo) || empty($descripcion) || empty($fechaInicio) || empty($fechaFin) || empty($objetivoFinanciero)) {
            $error = "Todos los campos son obligatorios";
        } else {
            $proyecto->setTitulo($titulo);
            $proyecto->setDescripcion($descripcion);
            $proyecto->setFechaInicio($fechaInicio);
            $proyecto->setFechaFin($fechaFin);
            $proyecto->setObjetivoFinanciero($objetivoFinanciero);

            // Manejar la subida de la nueva foto
            if (!empty($_FILES['fotoProyecto']['name'])) {
                if (
                    $_FILES['fotoProyecto']['type'] != 'image/jpeg' &&
                    $_FILES['fotoProyecto']['type'] != 'image/webp' &&
                    $_FILES['fotoProyecto']['type'] != 'image/png'
                ) {
                    $error = "La foto no tiene el formato admitido, debe ser jpg, webp o png";
                } else {
                    $extension = pathinfo($_FILES['fotoProyecto']['name'], PATHINFO_EXTENSION);
                    $fotoProyecto = hash('sha256', uniqid()) . '.' . $extension;

                    if (!move_uploaded_file($_FILES['fotoProyecto']['tmp_name'], "web/fotosProyectos/$fotoProyecto")) {
                        die("Error al copiar la foto a la carpeta fotosProyectos");
                    }
                    // Actualizar la foto solo si se ha subido una nueva
                    $proyecto->setFotoProyecto($fotoProyecto);
                }
            } elseif (!empty($fotoTemporal)) {
                // Si no se subió una nueva foto pero hay una foto temporal
                $fotoProyecto = str_replace("temp_", "", $fotoTemporal); // Renombrar foto temporal a definitiva
                rename("web/fotosProyectos/$fotoTemporal", "web/fotosProyectos/$fotoProyecto");
                $proyecto->setFotoProyecto($fotoProyecto);
            } else {
                // Si no se subió una nueva foto y no hay foto temporal, mantener la foto antigua
                $proyecto->setFotoProyecto($fotoAntigua);
            }

            if ($error == '') {
                if ($proyectosDAO->update($proyecto)) {
                    // Borrar la foto antigua si se subió una nueva
                    if (!empty($_FILES['fotoProyecto']['name']) && $fotoAntigua && $proyecto->getFotoProyecto() !== $fotoAntigua) {
                        unlink("web/fotosProyectos/$fotoAntigua");
                    }

                    // Borrar cualquier foto temporal remanente
                    if (!empty($fotoTemporal) && file_exists("web/fotosProyectos/$fotoTemporal")) {
                        unlink("web/fotosProyectos/$fotoTemporal");
                    }

                    header('location: index.php?accion=misProyectosOrganizacion');
                    die();
                } else {
                    $error = "No se ha podido actualizar el proyecto";
                }
            }
        }
    }
    require 'app/vistas/editarProyecto.php';
}


public function borrarProyecto() {
    // Verificar si el idOrganizacion está en la sesión
    if (!isset($_SESSION['idOrganizacion'])) {
        echo "ID de organización no encontrado en la sesión.";
        return;
    }

    // Obtener el idOrganizacion de la sesión
    $idOrganizacion = $_SESSION['idOrganizacion'];
    $idProyecto = $_GET['idProyecto'];

    // Conectar a la base de datos
    $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
    $conn = $connexionDB->getConnexion();

    // Eliminar el proyecto
    $proyectosDAO = new ProyectosDAO($conn);
    $fotoProyecto = $proyectosDAO->delete($idProyecto);

    if ($fotoProyecto) {
        // Si se eliminó el proyecto, borrar la foto del servidor
        $filePath = "web/fotosProyectos/$fotoProyecto";
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    header('location: index.php?accion=misProyectosOrganizacion');
    die();
}

public function verTodosLosProyectos() {
    $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
    $conn = $connexionDB->getConnexion();
    $proyectosDAO = new ProyectosDAO($conn);
    $proyectos = $proyectosDAO->getAllProyectos(); // Asumiendo que existe un método getAllProyectos en ProyectosDAO
    require 'app/vistas/verTodosLosProyectos.php';
}

public function inscribirseVoluntariadoTodosProyectos() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $idProyecto = htmlspecialchars($_POST['idProyecto']);
        $fechaInicio = htmlspecialchars($_POST['fechaInicio']);
        $fechaFin = htmlspecialchars($_POST['fechaFin']);
        $returnUrl = htmlspecialchars($_POST['returnUrl']);

        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        $voluntarioDAO = new VoluntariosDAO($conn);
        $voluntario = new Voluntario();
        $voluntario->setIdUsuario($_SESSION['idUsuario']);
        $voluntario->setIdProyecto($idProyecto);
        $voluntario->setFechaInicio($fechaInicio);
        $voluntario->setFechaFin($fechaFin);

        if ($voluntarioDAO->insert($voluntario)) {
            $_SESSION['message'] = "Te has inscrito exitosamente como voluntario.";
        } else {
            $_SESSION['message'] = "Hubo un problema al inscribirse como voluntario.";
        }

        header('Location: ' . $returnUrl);
        exit();
    }
}




}
<?php

class ControladorProyectos{

    public function misProyectosOrganizacion(){
        
   if (!isset($_SESSION['idOrganizacion'])) {
       echo "ID de organización no encontrado en la sesión.";
       return;
   }

   
   if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Organizacion') {
       echo "Acceso denegado. Rol insuficiente.";
       return;
   }

 
   $idOrganizacion = $_SESSION['idOrganizacion'];

   
   $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
   $conn = $connexionDB->getConnexion();

   
   $organizacionesDAO = new OrganizacionesDAO($conn);
   $organizacion = $organizacionesDAO->getOrganizacionById($idOrganizacion);

  
   if (!$organizacion) {
      
       echo "Organización no encontrada.";
       return;
   }

   
   $usuariosDAO = new UsuariosDAO($conn);
   $usuarios = $usuariosDAO->getAllUsuarios();

  
   $proyectosDAO = new ProyectosDAO($conn);
   $proyectos = $proyectosDAO->getProyectosByOrganizacion($idOrganizacion);

   require 'app/vistas/misProyectos.php';
   }

   public function crearProyecto(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      
        if (!isset($_SESSION['idOrganizacion'])) {
            echo "ID de organización no encontrado en la sesión.";
            return;
        }

       
        $idOrganizacion = $_SESSION['idOrganizacion'];

       
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

      
        $titulo = htmlspecialchars($_POST['titulo']);
        $descripcion = htmlspecialchars($_POST['descripcion']);
        $fechaInicio = htmlspecialchars($_POST['fechaInicio']);
        $fechaFin = htmlspecialchars($_POST['fechaFin']);
        $objetivoFinanciero = htmlspecialchars($_POST['objetivoFinanciero']);
        $fotoProyecto = '';

        
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
       
        require 'app/vistas/crearProyecto.php';
    }
}


public function crearProyectoAdmin(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $idOrganizacion = $_POST['idOrganizacion'];

        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        $titulo = htmlspecialchars($_POST['titulo']);
        $descripcion = htmlspecialchars($_POST['descripcion']);
        $fechaInicio = htmlspecialchars($_POST['fechaInicio']);
        $fechaFin = htmlspecialchars($_POST['fechaFin']);
        $objetivoFinanciero = htmlspecialchars($_POST['objetivoFinanciero']);
        $fotoProyecto = '';

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
            header('location: index.php?accion=verTodosLosProyectosAdmin');
            die();
        } else {
            echo "No se ha podido crear el proyecto.";
        }
    } else {
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
        $organizacionesDAO = new OrganizacionesDAO($conn);
        $organizaciones = $organizacionesDAO->getAllOrganizaciones();

        require 'app/vistas/crearProyectoAdmin.php';
    }
}

public function editarProyecto() {
    $error = '';

    
    $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
    $conn = $connexionDB->getConnexion();

   
    $idProyecto = htmlspecialchars($_GET['idProyecto']);

    $proyectosDAO = new ProyectosDAO($conn);
    $proyecto = $proyectosDAO->getById($idProyecto);

 
    $fotoAntigua = $proyecto->getFotoProyecto();

   
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     
        $titulo = htmlspecialchars($_POST['titulo']);
        $descripcion = htmlspecialchars($_POST['descripcion']);
        $fechaInicio = date('Y-m-d', strtotime(htmlspecialchars($_POST['fechaInicio'])));
        $fechaFin = date('Y-m-d', strtotime(htmlspecialchars($_POST['fechaFin'])));
        $objetivoFinanciero = htmlspecialchars($_POST['objetivoFinanciero']);
        $fotoTemporal = isset($_POST['fotoTemporal']) ? htmlspecialchars($_POST['fotoTemporal']) : '';

       
        if (empty($titulo) || empty($descripcion) || empty($fechaInicio) || empty($fechaFin) || empty($objetivoFinanciero)) {
            $error = "Todos los campos son obligatorios";
        } else {
            $proyecto->setTitulo($titulo);
            $proyecto->setDescripcion($descripcion);
            $proyecto->setFechaInicio($fechaInicio);
            $proyecto->setFechaFin($fechaFin);
            $proyecto->setObjetivoFinanciero($objetivoFinanciero);

         
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
               
                    $proyecto->setFotoProyecto($fotoProyecto);
                }
            } elseif (!empty($fotoTemporal)) {
            
                $fotoProyecto = str_replace("temp_", "", $fotoTemporal); 
                rename("web/fotosProyectos/$fotoTemporal", "web/fotosProyectos/$fotoProyecto");
                $proyecto->setFotoProyecto($fotoProyecto);
            } else {
           
                $proyecto->setFotoProyecto($fotoAntigua);
            }

            if ($error == '') {
                if ($proyectosDAO->update($proyecto)) {
                 
                    if (!empty($_FILES['fotoProyecto']['name']) && $fotoAntigua && $proyecto->getFotoProyecto() !== $fotoAntigua) {
                        unlink("web/fotosProyectos/$fotoAntigua");
                    }

                 
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

public function editarProyectoAdmin() {
    $error = '';

  
    $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
    $conn = $connexionDB->getConnexion();

   
    $idProyecto = htmlspecialchars($_GET['idProyecto']);
   
    $proyectosDAO = new ProyectosDAO($conn);
    $proyecto = $proyectosDAO->getById($idProyecto);

  
    $fotoAntigua = $proyecto->getFotoProyecto();

   
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       
        $titulo = htmlspecialchars($_POST['titulo']);
        $descripcion = htmlspecialchars($_POST['descripcion']);
        $fechaInicio = date('Y-m-d', strtotime(htmlspecialchars($_POST['fechaInicio'])));
        $fechaFin = date('Y-m-d', strtotime(htmlspecialchars($_POST['fechaFin'])));
        $objetivoFinanciero = htmlspecialchars($_POST['objetivoFinanciero']);
        $fotoTemporal = isset($_POST['fotoTemporal']) ? htmlspecialchars($_POST['fotoTemporal']) : '';

 
        if (empty($titulo) || empty($descripcion) || empty($fechaInicio) || empty($fechaFin) || empty($objetivoFinanciero)) {
            $error = "Todos los campos son obligatorios";
        } else {
            $proyecto->setTitulo($titulo);
            $proyecto->setDescripcion($descripcion);
            $proyecto->setFechaInicio($fechaInicio);
            $proyecto->setFechaFin($fechaFin);
            $proyecto->setObjetivoFinanciero($objetivoFinanciero);

          
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
                  
                    $proyecto->setFotoProyecto($fotoProyecto);
                }
            } elseif (!empty($fotoTemporal)) {
                
                $fotoProyecto = str_replace("temp_", "", $fotoTemporal); 
                rename("web/fotosProyectos/$fotoTemporal", "web/fotosProyectos/$fotoProyecto");
                $proyecto->setFotoProyecto($fotoProyecto);
            } else {
              
                $proyecto->setFotoProyecto($fotoAntigua);
            }

            if ($error == '') {
                if ($proyectosDAO->update($proyecto)) {
                    
                    if (!empty($_FILES['fotoProyecto']['name']) && $fotoAntigua && $proyecto->getFotoProyecto() !== $fotoAntigua) {
                        unlink("web/fotosProyectos/$fotoAntigua");
                    }

                    
                    if (!empty($fotoTemporal) && file_exists("web/fotosProyectos/$fotoTemporal")) {
                        unlink("web/fotosProyectos/$fotoTemporal");
                    }

                    header('location: index.php?accion=verTodosLosProyectosAdmin');
                    die();
                } else {
                    $error = "No se ha podido actualizar el proyecto";
                }
            }
        }
    }
    require 'app/vistas/editarProyectoAdmin.php';
}


public function borrarProyecto() {
    if (!isset($_SESSION['idOrganizacion'])) {
        echo "ID de organización no encontrado en la sesión.";
        return;
    }

    $idOrganizacion = $_SESSION['idOrganizacion'];
    $idProyecto = $_GET['idProyecto'];

 
    $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
    $conn = $connexionDB->getConnexion();

  
    $proyectosDAO = new ProyectosDAO($conn);
    $fotoProyecto = $proyectosDAO->delete($idProyecto);

    if ($fotoProyecto) {
     
        $filePath = "web/fotosProyectos/$fotoProyecto";
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    header('location: index.php?accion=misProyectosOrganizacion');
    die();
}
public function borrarProyectoAdmin() {

    if (!isset($_SESSION['idOrganizacion'])) {
        echo "ID de organización no encontrado en la sesión.";
        return;
    }

    $idOrganizacion = $_SESSION['idOrganizacion'];
    $idProyecto = $_GET['idProyecto'];

    $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
    $conn = $connexionDB->getConnexion();

    
    $proyectosDAO = new ProyectosDAO($conn);
    $fotoProyecto = $proyectosDAO->delete($idProyecto);

    if ($fotoProyecto) {

        $filePath = "web/fotosProyectos/$fotoProyecto";
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    header('location: index.php?accion=verTodosLosProyectosAdmin');
    die();
}

public function verTodosLosProyectos() {
    $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
    $conn = $connexionDB->getConnexion();
    $proyectosDAO = new ProyectosDAO($conn);
    $proyectos = $proyectosDAO->getAllProyectos(); 
    require 'app/vistas/verTodosLosProyectos.php';
}

public function verTodosLosProyectosAdmin() {
    $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
    $conn = $connexionDB->getConnexion();
    $proyectosDAO = new ProyectosDAO($conn);
    $proyectos = $proyectosDAO->getAllProyectos(); 
    require 'app/vistas/verTodosLosProyectosAdmin.php';
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
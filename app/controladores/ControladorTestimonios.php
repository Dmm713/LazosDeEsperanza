<?php

class ControladorTestimonios{
    public function misTestimoniosOrganizacion(){
      
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

     
        $testimoniosDAO = new TestimoniosDAO($conn);
        $testimonios = $testimoniosDAO->getTestimoniosByOrganizacion($idOrganizacion);


        require 'app/vistas/misTestimonios.php';
    }

    public function crearTestimonio(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            if (!isset($_SESSION['idOrganizacion'])) {
                echo "ID de organización no encontrado en la sesión.";
                return;
            }

      
            $idOrganizacion = $_SESSION['idOrganizacion'];

      
            $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnexion();

   
            $nombre = htmlspecialchars($_POST['nombre']);
            $apellidos = htmlspecialchars($_POST['apellidos']);
            $problema = htmlspecialchars($_POST['problema']);
            $solucion = htmlspecialchars($_POST['solucion']);
            $foto = '';

          
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
           
            require 'app/vistas/crearTestimonio.php';
        }
    }


    public function crearTestimonioAdmin(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $error = '';
        
            $idOrganizacion = $_POST['idOrganizacion'];
        
            $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnexion();
        
            $nombre = htmlspecialchars($_POST['nombre']);
            $apellidos = htmlspecialchars($_POST['apellidos']);
            $problema = htmlspecialchars($_POST['problema']);
            $solucion = htmlspecialchars($_POST['solucion']);
            $foto = '';
        
            // Validar los datos
            if (empty($idOrganizacion) || empty($nombre) || empty($apellidos) || empty($problema) || empty($solucion)) {
                $error = "Todos los campos son obligatorios.";
            } elseif (strlen($problema) > 500 || strlen($solucion) > 500) {
                $error = "El campo 'problema' y 'solución' no deben exceder los 500 caracteres.";
            } else {
                if (!empty($_FILES['foto']['name'])) {
                    if (
                        $_FILES['foto']['type'] != 'image/jpeg' &&
                        $_FILES['foto']['type'] != 'image/webp' &&
                        $_FILES['foto']['type'] != 'image/png'
                    ) {
                        $error = "La foto no tiene el formato admitido, debe ser jpg, webp o png";
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
        
                if ($error == '') {
                    $testimonio = new Testimonio();
                    $testimonio->setIdOrganizacion($idOrganizacion);
                    $testimonio->setNombre($nombre);
                    $testimonio->setApellidos($apellidos);
                    $testimonio->setProblema($problema);
                    $testimonio->setSolucion($solucion);
                    $testimonio->setFoto($foto);
        
                    $testimoniosDAO = new TestimoniosDAO($conn);
                    if ($testimoniosDAO->insertTestimonio($testimonio)) {
                        header('location: index.php?accion=verTodosLosTestimoniosAdmin');
                        die();
                    } else {
                        $error = "No se ha podido crear el testimonio.";
                    }
                }
            }
        
            // Obtener todas las organizaciones
            $organizacionesDAO = new OrganizacionesDAO($conn);
            $organizaciones = $organizacionesDAO->getAllOrganizaciones();
        
            // Mostrar el formulario de creación de testimonios
            require 'app/vistas/crearTestimonioAdmin.php';
        } else {
            // Obtener todas las organizaciones
            $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnexion();
            $organizacionesDAO = new OrganizacionesDAO($conn);
            $organizaciones = $organizacionesDAO->getAllOrganizaciones();
        
            // Mostrar el formulario de creación de testimonios
            require 'app/vistas/crearTestimonioAdmin.php';
        }
        
    }



    public function editarTestimonio() {
        $error = '';

    
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

     
        $idTestimonio = htmlspecialchars($_GET['idTestimonio']);
     
        $testimoniosDAO = new TestimoniosDAO($conn);
        $testimonio = $testimoniosDAO->getTestimonioById($idTestimonio);

 
        $fotoAntigua = $testimonio->getFoto();

        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         
            $nombre = htmlspecialchars($_POST['nombre']);
            $apellidos = htmlspecialchars($_POST['apellidos']);
            $problema = htmlspecialchars($_POST['problema']);
            $solucion = htmlspecialchars($_POST['solucion']);
            $fotoTemporal = isset($_POST['fotoTemporal']) ? htmlspecialchars($_POST['fotoTemporal']) : '';

         
            if (empty($nombre) || empty($apellidos) || empty($problema) || empty($solucion)) {
                $error = "Todos los campos son obligatorios";
            } else {
                $testimonio->setNombre($nombre);
                $testimonio->setApellidos($apellidos);
                $testimonio->setProblema($problema);
                $testimonio->setSolucion($solucion);

               
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
                        
                        $testimonio->setFoto($foto);
                    }
                } elseif (!empty($fotoTemporal)) {
                    
                    $foto = str_replace("temp_", "", $fotoTemporal); 
                    rename("web/fotosTestimonios/$fotoTemporal", "web/fotosTestimonios/$foto");
                    $testimonio->setFoto($foto);
                } else {
                    
                    $testimonio->setFoto($fotoAntigua);
                }

                if ($error == '') {
                    if ($testimoniosDAO->updateTestimonio($testimonio)) {
                        
                        if (!empty($_FILES['foto']['name']) && $fotoAntigua && $testimonio->getFoto() !== $fotoAntigua) {
                            unlink("web/fotosTestimonios/$fotoAntigua");
                        }

                      
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


    public function editarTestimonioAdmin() {
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
            } elseif (strlen($problema) > 500 || strlen($solucion) > 500) {
                $error = "El campo 'problema' y 'solución' no deben exceder los 500 caracteres.";
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
                        
                        $testimonio->setFoto($foto);
                    }
                } elseif (!empty($fotoTemporal)) {
                    // Si no se subió una nueva foto pero hay una foto temporal
                    $foto = str_replace("temp_", "", $fotoTemporal); 
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
        
                        header('location: index.php?accion=verTodosLosTestimoniosAdmin');
                        die();
                    } else {
                        $error = "No se ha podido actualizar el testimonio";
                    }
                }
            }
        }
        require 'app/vistas/editarTestimonioAdmin.php';
        
    }



    public function borrarTestimonio() {
       
        if (!isset($_SESSION['idOrganizacion'])) {
            echo "ID de organización no encontrado en la sesión.";
            return;
        }

        
        $idOrganizacion = $_SESSION['idOrganizacion'];
        $idTestimonio = $_GET['idTestimonio'];

      
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        
        $testimoniosDAO = new TestimoniosDAO($conn);
        $foto = $testimoniosDAO->deleteTestimonio($idTestimonio);

        if ($foto) {
          
            $filePath = "web/fotosTestimonios/$foto";
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        header('location: index.php?accion=misTestimoniosOrganizacion');
        die();
    }


    public function borrarTestimonioAdmin() {
       
        if (!isset($_SESSION['idOrganizacion'])) {
            echo "ID de organización no encontrado en la sesión.";
            return;
        }

        
        $idOrganizacion = $_SESSION['idOrganizacion'];
        $idTestimonio = $_GET['idTestimonio'];

      
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        
        $testimoniosDAO = new TestimoniosDAO($conn);
        $foto = $testimoniosDAO->deleteTestimonio($idTestimonio);

        if ($foto) {
          
            $filePath = "web/fotosTestimonios/$foto";
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        header('location: index.php?accion=verTodosLosTestimoniosAdmin');
        die();
    }

    public function verTodosLosTestimonios() {
       
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
        
      
        $testimoniosDAO = new TestimoniosDAO($conn);
        
        
        $testimonios = $testimoniosDAO->getAllTestimonios(); 
        
        
        require 'app/vistas/verTodosLosTestimonios.php';
    }
    
    public function verTodosLosTestimoniosAdmin() {
   
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
        
 
        $testimoniosDAO = new TestimoniosDAO($conn);
        
     
        $testimonios = $testimoniosDAO->getAllTestimonios(); 
        
        
        require 'app/vistas/verTodosLosTestimoniosAdmin.php';
    }
}
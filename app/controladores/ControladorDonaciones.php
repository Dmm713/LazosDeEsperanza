<?php
class ControladorDonaciones {
    public function procesarDonacion() {
        // Verificar qué datos se están recibiendo
        error_log(print_r($_POST, true));

        // Verifica si se han recibido todos los datos necesarios
        if (isset($_POST['idProyecto'], $_POST['cantidad'], $_POST['numeroTarjeta'], $_POST['mes'], $_POST['year'], $_POST['ccv'], $_POST['returnUrl'])) {
            // Conectar a la base de datos
            $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnexion();

            // Obtener datos del formulario
            $idUsuario = $_SESSION['idUsuario'];
            $idProyecto = $_POST['idProyecto'];
            $cantidad = $_POST['cantidad'];
            $numeroTarjeta = $_POST['numeroTarjeta'];
            $mes = $_POST['mes'];
            $year = $_POST['year'];
            $ccv = $_POST['ccv'];
            $returnUrl = $_POST['returnUrl'];

            // Verificar si el idProyecto existe
            $proyectosDAO = new ProyectosDAO($conn);
            $proyecto = $proyectosDAO->getProyectoById($idProyecto);
            if (!$proyecto) {
                $_SESSION['message'] = "El proyecto no existe.";
                $_SESSION['message_type'] = "error";
                header('Location: ' . $returnUrl);
                exit();
            }

            // Crear una instancia de Donacion
            $donacion = new Donacion($idUsuario, $idProyecto, $cantidad);
            $donacion->setNumeroTarjeta($numeroTarjeta);
            $donacion->setMes($mes);
            $donacion->setYear($year);
            $donacion->setCcv($ccv);

            // Insertar la donación en la base de datos
            $donacionesDAO = new DonacionesDAO($conn);
            if ($donacionesDAO->insert($donacion)) {
                $_SESSION['message'] = "Su donación se ha realizado correctamente.";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Su donación no se ha podido realizar.";
                $_SESSION['message_type'] = "error";
            }
            header('Location: ' . $returnUrl);
            exit();
        } else {
            $_SESSION['message'] = "Datos incompletos.";
            $_SESSION['message_type'] = "error";
            header('Location: ' . $_POST['returnUrl']);
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos Los Usuarios</title>
    <link rel="stylesheet" href="web/css/estilosTodosLosUsuarios.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Changa:wght@200..800&display=swap');
    </style>
</head>

<body>
    <header>
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <div class="logo-container">
                    <img src="web/Images/lazos de esperanza Blanco.png" alt="Lazos de Esperanza" class="logo">
                </div>
                <!-- Texto del Header -->
                <div class="title-container">
                    <h1>TODOS LOS USUARIOS</h1>
                </div>
                <!-- Botón para insertar un nuevo usuario -->
                <div class="new-user-container">
                    <a href="index.php?accion=insertarUsuario" class="btn btn-primary">Insertar Nuevo Usuario</a>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="row">
            <?php foreach ($usuarios as $usuario) : ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="web/fotosUsuarios/<?= htmlspecialchars($usuario->getFoto()) ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h3><?= htmlspecialchars($usuario->getNombre()) ?></h3>
                            <p><?= htmlspecialchars($usuario->getApellidos()) ?></p>
                            <div class="btn-group">
                                <a href="index.php?accion=editarUsuario&idUsuario=<?= $usuario->getIdUsuario() ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="index.php?accion=borrarUsuario&idUsuario=<?= $usuario->getIdUsuario() ?>" class="btn btn-primary btn-delete"><i class="fa-solid fa-trash-can" style="color: red;"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Botón para volver -->
        <div class="return-container">
            <a href="index.php?accion=paginaPrincipal" class="btn btn-secondary hover-door"><i class="fa-solid fa-left-long"></i></a>
        </div>
    </div>

    <div id="custom-confirm" class="custom-confirm">
        <div class="confirm-box">
            <p>¿Está seguro que desea borrar el usuario?</p>
            <button id="confirm-yes" class="btn">Sí</button>
            <button id="confirm-no" class="btn">No</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete');
            const confirmBox = document.getElementById('custom-confirm');
            const confirmYes = document.getElementById('confirm-yes');
            const confirmNo = document.getElementById('confirm-no');
            let currentLink = null;

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    currentLink = this.href;
                    confirmBox.style.display = 'flex';
                });
            });

            confirmYes.addEventListener('click', function() {
                if (currentLink) {
                    window.location.href = currentLink;
                }
            });

            confirmNo.addEventListener('click', function() {
                confirmBox.style.display = 'none';
                currentLink = null;
            });
        });
    </script>
</body>

</html>

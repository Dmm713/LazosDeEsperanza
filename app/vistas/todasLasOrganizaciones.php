<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todas Las Organizaciones</title>
    <link rel="stylesheet" href="web/css/estilosTodasLasOrganizaciones.css">
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
                    <h1>TODAS LAS ORGANIZACIONES</h1>
                </div>
                <!-- Botón para insertar una nueva organización -->
                <div class="new-user-container">
                    <a href="index.php?accion=insertarOrganizacion" class="btn btn-primary">Insertar Nueva Organización</a>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="row">
            <?php foreach ($organizaciones as $organizacion) : ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="web/fotosUsuarios/<?= htmlspecialchars($organizacion->getFoto()) ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <div class="card-text-container">
                                <h3><?= htmlspecialchars($organizacion->getNombre()) ?></h3>
                                <p><?= htmlspecialchars($organizacion->getDescripcion()) ?></p>
                            </div>
                            <div class="btn-group">
                                <a href="index.php?accion=editarOrganizacion&idOrganizacion=<?= $organizacion->getIdOrganizacion() ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="#" class="btn btn-primary btn-delete" data-id="<?= $organizacion->getIdOrganizacion() ?>"><i class="fa-solid fa-trash-can" style="color: red;"></i></a>
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
            <p>¿Está seguro que desea borrar la organización?</p>
            <button id="confirm-yes" class="btn">Sí</button>
            <button id="confirm-no" class="btn">No</button>
        </div>
    </div>

    <script>

document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const accessibility = "<?php echo $_SESSION['accessibility'] ?>"
            console.log(accessibility)
            if (accessibility === 'yes') {
                var elementos = document.querySelectorAll('h1, p, a, button');

                function agregarEventos(elemento) {
                    elemento.addEventListener("mouseover", function(event) {
                        hablarTexto(event.target.innerText);
                    });

                    elemento.addEventListener("mouseout", function() {
                        detenerTexto();
                    });

                    elemento.addEventListener("focus", function(event) {
                        hablarTexto(event.target.innerText);
                    });

                    elemento.addEventListener("blur", function() {
                        detenerTexto();
                    });
                }

                elementos.forEach(agregarEventos);

                function hablarTexto(texto) {
                    var voz = new SpeechSynthesisUtterance();
                    voz.text = texto;
                    window.speechSynthesis.speak(voz);
                }

                function detenerTexto() {
                    window.speechSynthesis.cancel();
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete');
            const confirmBox = document.getElementById('custom-confirm');
            const confirmYes = document.getElementById('confirm-yes');
            const confirmNo = document.getElementById('confirm-no');
            let currentId = null;

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    currentId = this.dataset.id;
                    confirmBox.style.display = 'flex';
                });
            });

            confirmYes.addEventListener('click', function() {
                if (currentId) {
                    window.location.href = 'index.php?accion=borrarOrganizacion&idOrganizacion=' + currentId;
                }
            });

            confirmNo.addEventListener('click', function() {
                confirmBox.style.display = 'none';
                currentId = null;
            });
        });
    </script>
</body>
</html>

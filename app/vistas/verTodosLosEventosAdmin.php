<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos los Eventos</title>
    <link rel="stylesheet" href="web/css/estilosVerTodosLosEventos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Changa:wght@200..800&display=swap');
    </style>
</head>

<body>
    <header>
        <div class="header-content">
            <div class="logo-container">
                <img src="web/Images/lazos de esperanza Blanco.png" alt="Logo" class="logo">
            </div>
            <div class="title-container">
                <h1>Lista de Eventos</h1>
            </div>
            <div class="new-user-container">
                <a href="index.php?accion=crearEventoAdmin" class="btn btn-primary">Insertar Nuevo Evento</a>
                <a href="index.php?accion=paginaPrincipal" class="btn btn-primary"><i class="fa-solid fa-left-long"></i></a>
            </div>
        </div>
    </header>
    <main>
        <?php if (!empty($eventos)) : ?>
            <div class="event-container">
                <?php foreach ($eventos as $evento): ?>
                    <div class="event-card">
                        <img src="web/fotosEventos/<?php echo $evento->getFotoEvento(); ?>" alt="Evento" class="event-image">
                        <div class="event-content">
                            <h2><?php echo $evento->getTitulo(); ?></h2>
                            <p><?php echo $evento->getDescripcion(); ?></p>
                            <p><strong>Fecha:</strong> <?php echo $evento->getFechaEvento(); ?></p>
                            <p><strong>Ubicación:</strong> <?php echo $evento->getUbicacion(); ?></p>
                            <a href="index.php?accion=editarEventoAdmin&idEvento=<?php echo $evento->getIdEvento(); ?>" class="btn-edit">Editar</a>
                            <a href="#" class="btn-delete" onclick="openModal(<?php echo $evento->getIdEvento(); ?>)">Borrar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p>No hay eventos disponibles.</p>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 Lazos De Esperanza</p>
    </footer>

    <!-- Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p>¿Está seguro de que desea borrar este evento?</p>
            <button id="confirmDelete" class="btn">Confirmar</button>
            <button class="btn" onclick="closeModal()">Cancelar</button>
        </div>
    </div>

    <script>
        let deleteEventId = null;

        function openModal(eventId) {
            deleteEventId = eventId;
            document.getElementById('deleteModal').style.display = 'block';
        }

        function closeModal() {
            deleteEventId = null;
            document.getElementById('deleteModal').style.display = 'none';
        }

        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (deleteEventId !== null) {
                window.location.href = `index.php?accion=borrarEventoAdmin&idEvento=${deleteEventId}`;
            }
        });

        window.onclick = function(event) {
            if (event.target == document.getElementById('deleteModal')) {
                closeModal();
            }
        }
    </script>
    <script>
            document.addEventListener("DOMContentLoaded", function() {
                const urlParams = new URLSearchParams(window.location.search);
                const accessibility = "<?php echo $_SESSION['accessibility'] ?>"
                console.log(accessibility)
                if (accessibility === 'yes') {
                    var elementos = document.querySelectorAll('h1, h5, h3, h2, p, a, button , label, input, strong, ul, li, textarea');

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

            document.addEventListener("DOMContentLoaded", function() {
                const urlParams = new URLSearchParams(window.location.search);
                const accessibility = urlParams.get('accessibility');
                const registerLink = document.getElementById('linkRegistrar');

                if (accessibility) {
                    registerLink.href += '&accessibility=' + accessibility;
                }
            });
        </script>
</body>

</html>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Donaciones</title>
    <link rel="stylesheet" href="web/css/estilosMisDonaciones.css">
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
                <h1>Mis Donaciones</h1>
            </div>
            <div class="new-user-container">
                <a href="index.php?accion=paginaPrincipal" class="btn btn-primary"><i class="fa-solid fa-left-long"></i></a>
            </div>
        </div>
    </header>
    <main>
        <?php if (!empty($donaciones)) : ?>
            <div class="donacion-container">
                <?php foreach ($donaciones as $donacion) : ?>
                    <div class="donacion-card">
                        <?php if ($donacion['fotoProyecto']) : ?>
                            <img src="web/fotosProyectos/<?php echo htmlspecialchars($donacion['fotoProyecto']); ?>" alt="Foto del proyecto" class="donacion-image">
                        <?php else : ?>
                            <img src="web/images/default-project.png" alt="Foto del proyecto" class="donacion-image">
                        <?php endif; ?>
                        <div class="donacion-content">
                            <h2><?php echo htmlspecialchars($donacion['nombreProyecto']); ?></h2>
                            <p><?php echo htmlspecialchars($donacion['descripcionProyecto']); ?></p>
                            <p><strong>Cantidad:</strong> <?php echo htmlspecialchars($donacion['cantidad']); ?></p>
                            <p><strong>Fecha:</strong> <?php echo htmlspecialchars($donacion['fecha']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="no-donaciones">
                <p>No has realizado ninguna donación.</p>
            </div>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 Lazos De Esperanza</p>
    </footer>
    <script>
            document.addEventListener("DOMContentLoaded", function() {
                const urlParams = new URLSearchParams(window.location.search);
                const accessibility = "<?php echo $_SESSION['accessibility'] ?>"
                console.log(accessibility)
                if (accessibility === 'yes') {
                    var elementos = document.querySelectorAll('h1, h5, h3, h2, p, a, button , label, input');

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

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($organizacion->getNombre()); ?></title>
    <link rel="stylesheet" href="web/css/estilosPaginaOrganizacion.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Changa:wght@200..800&display=swap');
    </style>
</head>

<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo-container">
                    <img src="web/logosOrganizaciones/<?= htmlspecialchars($organizacion->getLogo()) ?>" alt="Logo" class="logo">
                </div>
                <div class="title-container">
                    <h1><?php echo htmlspecialchars($organizacion->getNombre()); ?></h1>
                </div>
                <div class="new-user-container">
    <a href="index.php?accion=hazVoluntariado" class="btn btn-primary">Hacer Voluntariado</a>
    <a href="index.php?accion=donar" class="btn btn-primary">Donar</a>
    <a href="index.php?accion=donar" class="btn btn-primary volver">Puerta volver</a>
</div>

            </div>
        </div>
    </header>
    <div class="container">
        <div class="sobreNosotros">

            <section class="mission-vision-values">
                <div class="content-wrapper">
                    <img src="web/fotosUsuarios/<?= htmlspecialchars($organizacion->getFoto()) ?>" alt="Foto Fundación" class="vision-img">
                    <div class="vision">
                        <h2>Quiénes Somos</h2>
                        <p><?php echo htmlspecialchars($organizacion->getQuienesSomos()); ?></p>
                    </div>
                </div>
            </section>

            <section class="mission-vision-values">
                <div class="content-wrapper">
                    <div class="vision objetivos">
                        <h2>Objetivos</h2>
                        <p><?php echo htmlspecialchars($organizacion->getQuienesSomos()); ?></p>
                    </div>
                    <div class="vision">
                        <h2>Ciudades</h2>
                        <p><?php echo htmlspecialchars($organizacion->getQuienesSomos()); ?></p>
                    </div>
                </div>
            </section>

        </div>
        <div class="events">
            <h2>Eventos y Proyectos</h2>
            <?php
            $eventos = (new EventosDAO($conn))->getEventosByOrganizacion($organizacion->getIdOrganizacion());
            foreach ($eventos as $evento) {
                echo "<div class='event'>
                        <h3>" . htmlspecialchars($evento->getTitulo()) . "</h3>
                        <p>" . htmlspecialchars($evento->getDescripcion()) . "</p>
                        <p><strong>Fecha:</strong> " . htmlspecialchars($evento->getFechaEvento()) . "</p>
                        <img src='ruta/a/evento_foto.jpg' alt='Foto Evento'>
                      </div>";
            }
            ?>
        </div>
        <div class="testimonials">
            <h2>Testimonios</h2>
            <div class="testimonial">
                <img src="ruta/a/persona_ayudada.jpg" alt="Persona Ayudada">
                <p><strong>Problema:</strong> Descripción del problema</p>
                <p><strong>Solución:</strong> Cómo se le ha ayudado</p>
            </div>
            <div class="testimonial">
                <img src="ruta/a/persona_ayudada.jpg" alt="Persona Ayudada">
                <p><strong>Problema:</strong> Descripción del problema</p>
                <p><strong>Solución:</strong> Cómo se le ha ayudado</p>
            </div>
        </div>
    </div>
    <footer class="footer">
        <img src="ruta/a/logo.png" alt="Logo" class="logo">
        <p><strong>Contacto:</strong> <?php echo htmlspecialchars($organizacion->getTelefono()); ?>, <?php echo htmlspecialchars($organizacion->getEmail()); ?></p>
        <p><?php echo htmlspecialchars($organizacion->getDireccion()); ?></p>
        <p>Copyright © 2024</p>
    </footer>
</body>

</html>
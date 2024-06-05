<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal - Lazos de Esperanza</title>
    <link rel="stylesheet" href="web/css/estilosPaginaPrincipal.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <style>
        footer {
            background-image: url(web/Images/fondoFooter.png);
            background-size: cover;
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <!-- Logo -->
                <div class="col-auto">
                    <img src="web/Images/lazos de esperanza Blanco.png" alt="Lazos de Esperanza" class="logo">
                </div>

                <!-- Texto del Header -->
                <div class="col text-center">
                    <h1>Enlaza Con Nosotros Tu Solidaridad</h1>
                </div>

                <!-- Botones -->
                <div class="col-auto">
                    <?php if (isset($_SESSION['email'])) : ?>
                        <div class="user-container">
                            <div class="user-info">
                                <img class="fotoUsuario" src="web/fotosUsuarios/<?= $_SESSION['foto'] ?>" alt="Foto de usuario"><br>
                                <span class="emailUsuario"><?= $_SESSION['email'] ?></span>
                            </div>
                            <a id="linkRegistrar" href="index.php?accion=logout" class="sesion btn" style="background-color: white; color: #08929c;" tabindex="0">Cerrar Sesión</a>
                        </div>
                    <?php else : ?>
                        <a id="linkIniciarSesion" href="index.php?accion=login&accessibility=<?php echo $_SESSION['accessibility'] ?>" class="sesion btn" style="background-color: white; color: #08929c;" tabindex="0">Iniciar Sesión</a>
                        <a id="linkRegistrar" href="index.php?accion=registrar&accessibility=<?php echo $_SESSION['accessibility'] ?>" class="sesion btn" style="background-color: white; color: #08929c;" tabindex="0">Registrar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>
    <div>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav w-100 justify-content-around">
                        <li class="nav-item flex-grow-1">
                            <a class="nav-link" aria-current="page" href="#" style="text-align: center;">Inicio</a>
                        </li>
                        <li class="nav-item flex-grow-1">
                            <a class="nav-link" href="#" style="text-align: center;">Sobre Nosotros</a>
                        </li>
                        <li class="nav-item flex-grow-1">
                            <a class="nav-link" href="#" style="text-align: center;">Servicios</a>
                        </li>
                        <li class="nav-item flex-grow-1">
                            <a class="nav-link" href="#" style="text-align: center;">Contacto</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div>
        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'Usuario') : ?>
            <nav class="navbar navbar-expand-lg navbarAbajo">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav w-100 justify-content-around">
                            <li class="nav-item flex-grow-1">
                                <a class="nav-link navbarLink" aria-current="page" href="#" style="text-align: center;">Eventos</a>
                            </li>
                            <li class="nav-item flex-grow-1">
                                <a class="nav-link navbarLink" href="#" style="text-align: center;">Proyectos</a>
                            </li>
                            <li class="nav-item flex-grow-1">
                                <a class="nav-link navbarLink" href="#" style="text-align: center;">Mi Perfil</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        <?php elseif (isset($_SESSION['rol']) && $_SESSION['rol'] == 'Organizacion') : ?>
            <nav class="navbar navbar-expand-lg navbarAbajo">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav w-100 justify-content-around">
                            <li class="nav-item flex-grow-1">
                                <a class="nav-link navbarLink" aria-current="page" href="#" style="text-align: center;">Mi Perfil</a>
                            </li>
                            <li class="nav-item flex-grow-1">
                                <a class="nav-link navbarLink" href="#" style="text-align: center;">Mis Eventos</a>
                            </li>
                            <li class="nav-item flex-grow-1">
                                <a class="nav-link navbarLink" href="#" style="text-align: center;">Mis Proyectos</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        <?php elseif (isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin') : ?>
            <nav class="navbar navbar-expand-lg navbarAbajo">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav w-100 justify-content-around">
                            <li class="nav-item flex-grow-1">
                                <a class="nav-link navbarLink" aria-current="page" href="index.php?accion=verTodosLosUsuarios" style="text-align: center;">Usuarios</a>
                            </li>
                            <li class="nav-item flex-grow-1">
                                <a class="nav-link navbarLink" href="index.php?accion=verTodasLasOrganizaciones" style="text-align: center;">Organizaciones</a>
                            </li>
                            <li class="nav-item flex-grow-1">
                                <a class="nav-link navbarLink" href="#" style="text-align: center;">Eventos</a>
                            </li>
                            <li class="nav-item flex-grow-1">
                                <a class="nav-link navbarLink" href="#" style="text-align: center;">Proyectos</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        <?php endif; ?>
    </div>

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="3000">
                <img src="web/Images/unicef.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item" data-bs-interval="3000">
                <img src="web/Images/Dia-Mundial-contra-el-Cancer.png" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item" data-bs-interval="3000">
                <img src="web/Images/aedem.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Imagen Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente Imagen</span>
        </button>
    </div>

    <div class="">


        <div class="container">
            <h2>Organizaciones</h2>
            <div class="row card-container">
                <?php foreach ($organizaciones as $organizacion) : ?>
                    <div class="col-md-4 d-flex">
                        <div class="card" style="width: 18rem;">
                            <img src="web/fotosUsuarios/<?= htmlspecialchars($organizacion->getFoto()) ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($organizacion->getNombre()) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($organizacion->getDescripcion()) ?></p>
                                <a href="<?= htmlspecialchars($organizacion->getSitioWeb()) ?>" style="color: #3280d3; text-decoration: underline; text-align: center;"><?= htmlspecialchars($organizacion->getSitioWeb()) ?></a>
                                <a href="inicio.php?<?= htmlspecialchars($organizacion->getIdOrganizacion()) ?> " class="btn btn-primary">Ver Mas</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>


        <div class="sobreNosotros">
            <section class="intro">
                <div class="intro-content">
                    <h2>Sobre Nosotros</h2>
                    <p>
                        Lazos de Esperanza es una organización sin fines de lucro comprometida con el bienestar y el desarrollo integral de las comunidades más vulnerables. Fundada con la visión de transformar vidas y construir un futuro más justo, nuestra organización trabaja incansablemente para ofrecer apoyo, recursos y oportunidades a quienes más lo necesitan.

                        Desde nuestros inicios, hemos centrado nuestros esfuerzos en identificar y abordar las necesidades más urgentes de las comunidades desfavorecidas. Reconocemos que cada individuo y comunidad enfrenta desafíos únicos, por lo que adoptamos un enfoque holístico y personalizado en nuestras intervenciones. Nuestros programas abarcan una amplia gama de áreas, incluyendo educación, salud, desarrollo económico y apoyo social, asegurando que nuestras iniciativas sean inclusivas y sostenibles.

                        En Lazos de Esperanza, creemos firmemente en el poder de la colaboración y la participación comunitaria. Trabajamos estrechamente con líderes locales, organizaciones aliadas y voluntarios dedicados para construir redes de apoyo sólidas y efectivas. Nuestro equipo está compuesto por profesionales apasionados y comprometidos, que aportan su experiencia y conocimientos para diseñar e implementar proyectos que realmente marquen la diferencia.

                        A través de nuestras diversas iniciativas, buscamos no solo atender las necesidades inmediatas, sino también empoderar a las personas para que se conviertan en agentes de cambio en sus propias comunidades. Creemos que, al brindar las herramientas y oportunidades adecuadas, podemos ayudar a las personas a superar la adversidad y alcanzar su máximo potencial.

                        Cada día, nos inspiramos en las historias de resiliencia y superación de quienes se benefician de nuestro trabajo. Estos testimonios son el motor que nos impulsa a seguir adelante y a redoblar nuestros esfuerzos para construir un mundo más equitativo y lleno de esperanza.

                        Con Lazos de Esperanza, cada pequeño paso cuenta, y cada acción tiene el potencial de transformar vidas. Juntos, podemos tejer un futuro más brillante para todos.
                    </p>
                </div>
                
            </section>

            <section class="mission-vision-values">
                <div class="vision">
                    <h3>Visión</h3>
                    <p>
                        En Lazos de Esperanza, nuestra visión se centra en construir un mundo más justo y equitativo, donde cada individuo, sin importar su origen o situación, tenga la oportunidad de alcanzar su máximo potencial.
                        Aspiramos a ser un referente en la lucha por la justicia social y el desarrollo comunitario, estableciendo estándares elevados en la forma en que se abordan y resuelven los problemas sociales.
                        En Lazos de Esperanza, creemos que al unir esfuerzos y recursos, podemos crear un futuro donde la justicia social y el desarrollo comunitario no sean solo aspiraciones, sino realidades tangibles.
                        Nuestra visión nos guía y nos motiva a seguir trabajando con pasión y dedicación para transformar vidas y construir un mundo mejor para todos.
                    </p>
                    <p>
                        En Lazos de Esperanza, creemos que al unir esfuerzos y recursos, podemos crear un futuro donde la justicia social y el desarrollo comunitario no sean solo aspiraciones, sino realidades tangibles.
                        Nuestra visión nos guía y nos motiva a seguir trabajando con pasión y dedicación para transformar vidas y construir un mundo mejor para todos.
                    </p>
                </div>
                <img src="web/Images/sobreNosotros.png" alt="Descripción de la imagen" class="sobreNosotros-img">
            </section>

            <img src="web/Images/sobreNosotros.png" alt="Descripción de la imagen" class="foto2">
            <section class="history">
            
                <div>
                <h3>Nuestra Historia</h3>
                <p>Lazos de Esperanza nació del sueño de un niño pequeño al que le encantaba ayudar a las personas. Desde nuestros humildes comienzos, hemos crecido y expandido nuestras iniciativas, siempre con el mismo objetivo en mente: tender la mano a quienes más lo necesitan.

                    Los Inicios:
                    Todo comenzó con la visión inocente y generosa de [Nombre del Niño], un niño que, desde temprana edad, mostró un profundo deseo de ayudar a los demás. A los [edad del niño] años, [Nombre del Niño] dedicaba su tiempo libre a recolectar alimentos y ropa para las personas sin hogar de su comunidad. Sus primeros esfuerzos, aunque pequeños, impactaron significativamente a quienes recibieron su ayuda, y rápidamente comenzaron a inspirar a otros en su comunidad.

                    Crecimiento y Expansión:
                    A medida que [Nombre del Niño] crecía, también lo hacía su visión. En la adolescencia, logró movilizar a más personas y organizar campañas más grandes y efectivas. Con el apoyo de su familia, amigos y vecinos, las pequeñas iniciativas de ayuda comenzaron a formalizarse, y nació la idea de establecer una organización que pudiera abordar las necesidades de manera más estructurada y sostenible.

                    Con la fundación oficial de Lazos de Esperanza, se abrió un nuevo capítulo en nuestra historia. Lo que comenzó como el sueño de un niño se transformó en una organización comprometida con el bienestar de las comunidades vulnerables. Gracias al apoyo de donantes y colaboradores, pudimos expandir nuestros programas y recursos, estableciendo alianzas con instituciones educativas, centros de salud y empresas locales.

                    El Futuro:
                    Miramos hacia el futuro con optimismo y determinación. Nuestro compromiso sigue siendo el mismo: crear un mundo más justo y equitativo, donde todas las personas tengan la oportunidad de prosperar. Con la colaboración continua de voluntarios, donantes y aliados, estamos seguros de que podemos alcanzar nuevas metas y llevar esperanza a más comunidades alrededor del mundo.

                    Lazos de Esperanza es más que una organización; es un movimiento de solidaridad y cambio. A través de nuestras acciones, seguimos tejiendo una red de apoyo que fortalece y transforma vidas, manteniendo vivo el sueño que nos vio nacer.
                </p>
                </div>
               
            </section>
        </div>



        <footer>
            <div class="container__footer">
                <div class="box__footer">
                    <div class="logo">
                        <img src="web/Images/lazos de esperanza Blanco.png" alt="Lazos de Esperanza">
                    </div>
                    <div class="terms">
                        <p>Únete a "Lazos de Esperanza", una plataforma innovadora que transforma cómo interactúan las ONGs, voluntarios y beneficiarios. Con herramientas avanzadas y un fuerte enfoque en la accesibilidad, facilitamos que todos, sin importar sus habilidades, contribuyan a un cambio social significativo. ¡Tu lazo comienza aquí!</p>
                    </div>
                </div>
                <div class="box__footer">
                    <h2>Soluciones</h2>
                    <a href="https://www.google.com">App Desarrollo</a>
                    <a href="#">App Marketing</a>
                    <a href="#">IOS Desarrollo</a>
                    <a href="#">Android Desarrollo</a>
                </div>
                <div class="box__footer">
                    <h2>Compañia</h2>
                    <a href="#">Acerca de</a>
                    <a href="#">Trabajos</a>
                    <a href="#">Procesos</a>
                    <a href="#">Servicios</a>
                </div>
                <div class="box__footer">
                    <h2>Redes Sociales</h2>
                    <a href="#"><i class="fab fa-facebook-square">&nbsp</i> Facebook</a>
                    <a href="#"><i class="fab fa-twitter-square">&nbsp</i> Twitter</a>
                    <a href="#"><i class="fab fa-linkedin">&nbsp</i> Linkedin</a>
                    <a href="#"><i class="fab fa-instagram-square">&nbsp</i> Instagram</a>
                </div>
            </div>
            <div class="box__copyright">
                <hr>
                <p>Todos los derechos reservados © 2024 <b>Lazos de Esperanza</b></p>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
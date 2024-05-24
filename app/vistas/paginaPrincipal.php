<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer - Design for MagtimusPro</title>
    <link rel="stylesheet" href="../../web/css/estilosPaginaPrincipal.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <style>
        footer{
            background-image: url(../../web/Images/fondoFooter.png);
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
                    <img src="../../web/Images/lazos de esperanza Blanco.png" alt="Lazos de Esperanza" class="logo">
                </div>
                
                <!-- Texto del Header -->
                <div class="col text-center">
                    <h1>Enlaza Con Nosotros Tu Solidaridad</h1>
                </div>
                
                <!-- Botones -->
                <div class="col-auto">
                    <button class="sesion btn" style="background-color: white; color: #08929c;">Iniciar sesión</button>
                    <button class="sesion principales btn" style="background-color: white; color: #08929c;"><a href="index.php?accion=registrar">registrar</a></button>

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
    
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="3000">
                <img src="../../web/Images/unicef.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item" data-bs-interval="3000">
                <img src="../../web/Images/Dia-Mundial-contra-el-Cancer.png" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item" data-bs-interval="3000">
                <img src="../../web/Images/aedem.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    
    <div class="">
        <div class="cover">
            <h1>ESTO ES EL PRIMER TROZO DEL BODY</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque, rem. Ex sed nulla quidem non id excepturi molestias libero, officiis suscipit! Quisquam porro harum magni laborum quibusdam dolores minima possimus?</p>
        </div>
        <div class="container__article">
            <div class="box__article"></div>
            <div class="box__article"></div>
            <div class="box__article"></div>
            <div class="box__article"></div>
            <div class="box__article"></div>
            <div class="box__article"></div>
            <div class="box__article"></div>
            <div class="box__article"></div>
        </div>
    </div>
    
    <footer>
        <div class="container__footer">
            <div class="box__footer">
                <div class="logo">
                    <img src="../../web/Images/lazos de esperanza Blanco.png" alt="Lazos de Esperanza">
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
        document.addEventListener("DOMContentLoaded", function () {
            const urlParams = new URLSearchParams(window.location.search);
            const accessibility = urlParams.get('accessibility');
            
            if (accessibility === 'yes') {
                var elementos = document.querySelectorAll('h1, p, a, button');

                function agregarEventos(elemento) {
                    elemento.addEventListener("mouseover", function (event) {
                        hablarTexto(event.target.innerText);
                    });

                    elemento.addEventListener("mouseout", function () {
                        detenerTexto();
                    });

                    elemento.addEventListener("focus", function (event) {
                        hablarTexto(event.target.innerText);
                    });

                    elemento.addEventListener("blur", function () {
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
    </script>
</body>

</html>

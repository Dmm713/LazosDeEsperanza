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
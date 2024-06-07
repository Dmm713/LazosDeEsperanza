<!DOCTYPE html>
<html>
<head>
    <title>Página de Organización</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            text-align: center;
            color: #08929c;
        }
        .event-list {
            list-style-type: none;
            padding: 0;
            max-width: 800px;
            margin: 0 auto;
        }
        .event-item {
            display: flex;
            align-items: center;
            background-color: #fff;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .event-image {
            max-width: 150px;
            height: auto;
            margin-right: 20px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .event-details {
            flex: 1;
        }
        .event-details strong {
            font-size: 1.2em;
            color: #08929c;
        }
        .event-actions {
            display: flex;
            flex-direction: column;
            margin-left: 20px;
        }
        .event-actions a {
            margin: 5px 0;
            padding: 5px 10px;
            background-color: #08929c;
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9em;
            cursor: pointer;
        }
        .event-actions a:hover {
            background-color: #067a83;
        }
        .btn {
            display: block;
            width: fit-content;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #08929c;
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1em;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #067a83;
        }

        /* Custom Confirm Dialog */
        .custom-confirm {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .confirm-box {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .confirm-box p {
            margin-bottom: 20px;
            font-size: 1.2em;
            color: #333;
        }

        .confirm-box .btn-container {
            display: flex;
            justify-content: center;
        }

        .confirm-box .btn {
            background-color: #014949;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
            margin: 5px;
        }

        .confirm-box .btn:hover {
            background-color: #008080;
        }
    </style>
</head>
<body>
    <h1><?php echo htmlspecialchars($organizacion->getNombre()); ?></h1>
    <h2>Eventos</h2>
    <ul class="event-list">
        <?php foreach ($eventos as $evento): ?>
            <li class="event-item">
                <?php if (!empty($evento->getFotoEvento())): ?>
                    <img src="web/fotosEventos/<?php echo htmlspecialchars($evento->getFotoEvento()); ?>" alt="Foto del evento" class="event-image">
                <?php endif; ?>
                <div class="event-details">
                    <strong><?php echo htmlspecialchars($evento->getTitulo()); ?></strong><br>
                    <?php echo htmlspecialchars($evento->getDescripcion()); ?><br>
                    Fecha: <?php echo htmlspecialchars($evento->getFechaEvento()); ?><br>
                    Ubicación: <?php echo htmlspecialchars($evento->getUbicacion()); ?>
                </div>
                <div class="event-actions btn-group">
                    <a href="index.php?accion=editarEvento&idEvento=<?php echo $evento->getIdEvento(); ?>">Editar</a>
                    <a href="index.php?accion=eliminarEvento&idEvento=<?php echo $evento->getIdEvento(); ?>" class="btn-delete">Eliminar</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="index.php?accion=crearEvento" class="btn">Crear Nuevo Evento</a>
    <a href="index.php?accion=paginaPrincipal" class="btn">Volver</a>

    <div id="custom-confirm" class="custom-confirm">
        <div class="confirm-box">
            <p>¿Está seguro que desea borrar el evento?</p>
            <div class="btn-container">
                <button id="confirm-yes" class="btn">Sí</button>
                <button id="confirm-no" class="btn">No</button>
            </div>
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

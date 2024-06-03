<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos Los Usuarios</title>
    <link rel="stylesheet" href="web/css/estilosTodosLosUsuarios.css">
</head>
<body>  

<div class="container">
    <h2>Usuarios</h2>
    <div class="row">
        <?php foreach ($usuarios as $usuario) : ?>
            <div class="col-md-4">
                <div class="card">
                    <img src="web/fotosUsuarios/<?= htmlspecialchars($usuario->getFoto()) ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h3><?= htmlspecialchars($usuario->getNombre()) ?></h3>
                        <p><?= htmlspecialchars($usuario->getApellidos()) ?></p>
                        <div class="btn-group">
                            <a href="inicio.php?<?= htmlspecialchars($usuario->getIdUsuario()) ?> " class="btn btn-primary">Editar</a>
                            <a href="inicio.php? " class="btn btn-primary">Borrar</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>

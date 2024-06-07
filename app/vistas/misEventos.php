<!DOCTYPE html>
<html>
<head>
    <title>Página de Organización</title>
</head>
<body>
    <h1><?php echo htmlspecialchars($organizacion['nombre']); ?></h1>
    <h2>Eventos</h2>
    <ul>
        <?php foreach ($eventos as $evento): ?>
            <li>
                <strong><?php echo htmlspecialchars($evento->getTitulo()); ?></strong><br>
                <?php echo htmlspecialchars($evento->getDescripcion()); ?><br>
                Fecha: <?php echo htmlspecialchars($evento->getFechaEvento()); ?><br>
                Ubicación: <?php echo htmlspecialchars($evento->getUbicacion()); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

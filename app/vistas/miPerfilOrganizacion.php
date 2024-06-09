<!DOCTYPE html>
<html>
<head>
    <title>Mi Perfil</title>
    <style>
        body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

h1 {
    text-align: center;
    color: #08929c;
    margin-bottom: 20px;
}

form {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    box-sizing: border-box;
}

label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
}

input[type="text"],
input[type="url"],
input[type="tel"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

button {
    background-color: #08929c;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 20px;
    width: 100%;
    box-sizing: border-box;
    font-size: 16px;
}

button:hover {
    background-color: #066d73;
}

p {
    text-align: center;
    color: #ff6b6b;
}

    </style>
</head>
<body>
    <h1>Mi Perfil</h1>
    <?php if ($organizacion): ?>
        <form action="miPerfil.php" method="POST">
            <input type="hidden" name="idOrganizacion" value="<?= $organizacion->getIdOrganizacion() ?>">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" value="<?= $organizacion->getNombre() ?>" required><br>

            <label for="descripcion">Descripción:</label>
            <input type="text" name="descripcion" value="<?= $organizacion->getDescripcion() ?>" required><br>

            <label for="sitioWeb">Sitio Web:</label>
            <input type="url" name="sitioWeb" value="<?= $organizacion->getSitioWeb() ?>" required><br>

            <label for="telefono">Teléfono:</label>
            <input type="tel" name="telefono" value="<?= $organizacion->getTelefono() ?>" required><br>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?= $organizacion->getEmail() ?>" readonly><br>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" value="<?= $organizacion->getPassword() ?>" readonly><br>

            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" value="<?= $organizacion->getDireccion() ?>" required><br>

            <label for="foto">Foto:</label>
            <input type="text" name="foto" value="<?= $organizacion->getFoto() ?>" required><br>

            <label for="ciego">Ciego:</label>
            <input type="text" name="ciego" value="<?= $organizacion->getCiego() ?>" required><br>

            <label for="rol">Rol:</label>
            <input type="text" name="rol" value="<?= $organizacion->getRol() ?>" required><br>

            <label for="sid">SID:</label>
            <input type="text" name="sid" value="<?= $organizacion->getSid() ?>" required><br>

            <button type="submit">Actualizar Perfil</button>
        </form>
    <?php else: ?>
        <p>Perfil no encontrado.</p>
    <?php endif; ?>
</

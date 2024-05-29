<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f2f2f2;
        }
        .login-form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .login-form h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .login-form .input-group {
            margin-bottom: 15px;
        }
        .login-form .input-group label {
            display: block;
            margin-bottom: 5px;
        }
        .login-form .input-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .login-form .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }
        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
        }
        .login-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php session_start(); ?>
    <form class="login-form" method="POST" action="../../index.php?accion=login">
        <h2>Inicio de Sesión</h2>
        <?php if(isset($_SESSION['mensaje'])): ?>
            <div class="error">
                <?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?>
            </div>
        <?php endif; ?>
        <div class="input-group">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" required>
        </div>
        <div class="input-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>
        </div>
        <?php if(isset($_GET['accessibility'])): ?>
            <input type="hidden" name="accessibility" value="<?php echo htmlspecialchars($_GET['accessibility']); ?>">
        <?php endif; ?>
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>

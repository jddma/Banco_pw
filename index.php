<?php

    session_start();
    if(isset($_SESSION["id"]))
    {
        header("Location: panel/");
        exit();
    }

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/styles_index.css">
        <title>Banco</title>
    </head>
    <body>
        <div>
            <h1 id="title">Bienvenido a tu Banco</h1>
            <form action="includes/login.php" method="post">
                <input class="login" type="text" name="email" placeholder="Ingrese su correo" required>
                <input class="login" type="password" name="password" placeholder="Ingrese su contraseña" required>
                <input class="submit" type="submit" value="Ingresar">
                <a href="registrarse/"><p>¿Ha olvidado su contraseña?</p></a>
                <a href="registrarse/"><p>¿No tiene una cuenta?</p></a>
            </form>
        </div>
    </body>
</html>
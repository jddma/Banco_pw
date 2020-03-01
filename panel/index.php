<?php

    session_start();
    /**
     * para devolver al usuario en caso de que quiera ingresar sin haber 
     * iniciado sesion
     *  */    
    if (! isset($_SESSION["id"]))
    {
        header("Location: ../");
        exit();
    }

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inicio</title>
        <link rel="stylesheet" href="../css/styles_panel.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-dark bg-dark">
            <a class="navbar-brand">
            <img src="../img/logo_panel.png" width="30" height="30" class="d-inline-block align-top" alt="">
            Tu banco
            </a>
            <form class="form-inline">
                <button class="btn btn-success my-2 my-sm-0" type="submit">Mi Cuenta</button>_
                <a href="../includes/cerrar_sesion.php"><button class="btn btn-danger my-2 my-sm-0" type="submit">Cerrar Sesión</button></a>
            </form>
        </nav>
        <div class="container">
            <?php
                echo "Esta es una zona reservada para usuaros dicho esto hola señor(a) " . $_SESSION["apellidos"] . " " . $_SESSION["nombres"];
            ?>
        </div>
    </body>
</html>


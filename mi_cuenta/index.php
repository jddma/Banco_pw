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
        <title>MI cuenta</title>
    </head>
    <body>
        
    </body>
</html>
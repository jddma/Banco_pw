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
        <link rel="stylesheet" href="../css/styles_default.css">
        <link rel="stylesheet" href="../css/styles_transfers.css">
        <!--<link rel="stylesheet" href="../css/fontawesome.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
        <title>Nueva cuenta</title>
    </head>
    <body>
        <div class="header">
            <a><img class="logo-header" src="../img/logo_panel.png" alt=""></a>
            <h2 class="logo">Mi Banco</h2>
            <input type="checkbox" id="chk">
            <label for="chk" class="show-menu-btn">
                <i class="fas fa-ellipsis-h"></i>
            </label>
            <ul class="menu">
                <a href="../panel/">Inicio</a>
                <a href="../mi_cuenta/">Mi cuenta</a>
                <a href="../includes/cerrar_sesion.php"><input type="button" value="Cerrar sesión"></a>
                <label for="chk" class="hide-menu-btn">
                    <i class="fas fa-times"></i>
                </label>
            </ul>
        </div>
        <div class="content">
            <div class="usuario">
                <img src="../img/user_logo.png" alt="Usuario_Logo" class="user-logo">
                <p><?php echo "Usuario: ". $_SESSION["apellidos"]. " ". $_SESSION["nombres"]. "."?></p>
            </div>
            <form action="../includes/crear_nueva_cuenta.php" method="post">
                <p class="ref">Seleccione el tipo de cuenta</p>
                <select name="tipo">
                    <?php

                        require "../includes/database.php";
                        $sql="SELECT nombre_tipo FROM tipo_producto";
                        $result=$conn->prepare($sql);
                        $result->execute();
                        while($rows=$result->fetch(PDO::FETCH_ASSOC)):

                        ?>

                        <option><?php echo $rows["nombre_tipo"] ?></option>

                        <?php

                        endwhile;
                        echo "\n";
                        ?>
                    </select>
                    <input type="submit" id="submit" value="Crear cuenta">
            </form>
        </div>
    </body>
</html>
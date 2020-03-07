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
        <script type="text/javascript" src="../js/dialogos_transferencias.js"></script>
        <title>Retiros</title>
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
            <form action="../includes/retirar.php" method="post">
                <p class="ref">Cuenta de origen</p>
                <select name="origen" class="input" required>
                    <?php

                    require "../includes/database.php";
                    $sql="SELECT numero_producto FROM productos WHERE id_usuario= :id_usuario";
                    $result=$conn->prepare($sql);
                    $result->bindValue(":id_usuario", $_SESSION["id"]);
                    $result->execute();
                    while ($rows=$result->fetch(PDO::FETCH_ASSOC)):

                    ?>

                    <option><?php echo $rows["numero_producto"] ?></option>

                    <?php
                    echo "\n";
                    endwhile;

                    ?>
                </select>
                <p class="ref">Valor a retirar</p>
                <input type="number" name="valor" class="input" placeholder="############" required>
                <input type="submit" id="submit" value="Retirar">
            </form>
            <footer>
                <div class="footer_container">
                    <p class="footer">2020  - Tu banco ®  |  Bonilla. A, Melo. J, Pájaro. A.</p> 
                </div>
            </footer>
        </div>
    </body>
</html>
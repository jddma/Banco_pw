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
        <link rel="stylesheet" href="../css/styles_account.css">
        <!--<link rel="stylesheet" href="../css/fontawesome.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
        <title>Mi cuenta</title>
        <script src="../js/verificar_clave.js"></script>
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
        </div>
        <div class="info">
            <h2 class= "menu_title">Información Personal</h2>
            <div>
                
            </div>
        </div>
        <div class="info">
            <h2 class="menu_title">Cree su cuenta ahora</h2>
            <p class="description">No te quedes con las ganas y aprovecha todos los beneficios que ofrece la cuenta Tu Banco.</p>
            <a href="../crear_cuenta/"><input type="button" value="Ir" id="create_account"></a>
        </div>
        <div class="info">
            <h2 class= "menu_title">Mi dinero</h2>
            <div>
                <?php
                require "../includes/database.php";
                $sql = $conn->prepare("SELECT saldo, numero_producto FROM productos WHERE :usuario = productos.id_usuario;");
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->bindValue(":usuario", $_SESSION["id"]);
                $sql->execute();
                if($sql->rowCount() == 0)
                {
                    echo "<p id=\"aviso\">No tiene cuentas activas</p>";
                }
                else
                {
                    echo "<table class='balance_table'>\n";
                    echo "\t\t\t\t\t<tr>\n";
                    echo "\t\t\t\t\t\t<th>Cuenta</th><th>Saldo ($)</th>\n";
                    echo "\t\t\t\t\t</tr>\n";
                    
                    while($rows = $sql->fetch())
                    {
                        echo "\t\t\t\t\t<tr>\n";
                            echo "\t\t\t\t\t\t<td class='cell'>" . $rows["numero_producto"] . "</td><td class='cell'>" . $rows["saldo"] . "</td>\n";
                        echo "\t\t\t\t\t</tr>\n";
                    }
                    echo "\t\t\t\t</table>";
                }
                ?> 
            </div>
        </div>
        <div class="info">
            <h2 class= "menu_title">Cambiar mi contraseña</h2>
            <div class= "change_password">
                <form action="../includes/cambiar_clave.php" method="post" onsubmit="verificar_clave()">
                    <input type="email" name="mail" placeholder="Ingrese su correo" required>
                    <input id="pass1" type="password" name="password" placeholder="Nueva contraseña" required>
                    <input id="pass2" type="password" name="verify_password" placeholder="Repetir nueva contraseña" required>
                    <input type="submit" value="Cambiar mi contraseña">
                </form>
            </div>
        </div>
    </body>
</html>
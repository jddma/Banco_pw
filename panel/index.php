<!--<?php

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

?>-->
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/styles_default.css">
        <link rel="stylesheet" href="../css/styles_panel.css">
        <!--<link rel="stylesheet" href="../css/fontawesome.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
        <title>Panel de inicio</title>
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
                <p><?php echo "Bienvendo señor(a) ". $_SESSION["apellidos"]. " ". $_SESSION["nombres"]. "."?></p>
            </div>
            <div class="services-section">
                <div class="inner-width">
                    <h1 class="section-title">Nuestos Servicios</h1>
                    <div class="border"></div>
                    <div class="services-container">
                        <div class="service-box">
                            <div class="service-icon">
                                <a href="../transferencias"><img src="../img/transferir.png" alt="" class="service-logo"></a>
                            </div>
                            <div class="service-title">Transferencias a cuentas</div>
                            <div class="service-desc">
                                
                            </div>
                        </div>
                        <div class="service-box">
                            <div class="service-icon">
                                <a href="#"><img src="../img/pagos.png" alt="" class="service-logo"></i></a>
                            </div>
                            <div class="service-title">Pagos y Obligaciones</div>
                            <div class="service-desc">
                                
                            </div>
                        </div>
                        <div class="service-box">
                            <div class="service-icon">
                                <a href=#><img src="../img/tarjeta_credito.png" alt="" class="service-logo"></a>
                            </div>
                            <div class="service-title">Tarjetas de crédito</div>
                            <div class="service-desc">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer>
                <p class="footer">2020  - Tu banco ®  |  Bonilla. A, Melo. J, Pájaro. A.</p> 
            </footer>
        </div>
    </body>
</html>


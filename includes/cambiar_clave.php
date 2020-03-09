<?php

    //en caso de que se intente acceder a este script sin haber llenado el formulario
    if (! isset($_POST["password"]))
    {
        header("Location: ../mi_cuenta");
        exit();
    }
    

    session_start();

    /***
     * en caso de que se quiera ingresar sin haber iniciado sesion
     * * */
    if(!isset($_SESSION["id"])){
        header("Location ../");
        exit();
    }

    require "database.php";

    //en caso de que las contraseñas no coincidan
    if($_POST["password"] != $_POST["verify_password"]){
        header("Location: ../mi_cuenta");
        exit();
    }else{
        /**
         * actualiza la nueva contraseña en la base de datos
         */
        $sql = $conn->prepare("UPDATE usuario SET clave = :nueva_clave WHERE id_usuario = :id");
        $sql->bindValue(":nueva_clave", password_hash($_POST["password"], PASSWORD_DEFAULT));
        $sql->bindValue(":id", $_SESSION["id"]);
        $sql->execute();

        /**
         * enviar correo de verificacion al usuario
         */
        $origenNombre="Tu banco";
        $origenEmail='no-reply@banco.jddma.com';
        $header = "From: " . $origenNombre . " <" . $origenEmail . ">\r\n";
        $mensaje = "Estimado(a) ". $_SESSION["apellidos"]. " ". $_SESSION["nombres"]. " su contraseña ha sido actualizada correctamente.\nGracias por usar Tu Banco.";
        mail($_POST["mail"], "Contraseña de respaldo", $mensaje, $header);

        header("Location: ../panel/?nueva_clave=true");
        exit();
    }
?>
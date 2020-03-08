<?php
    require "database.php";

    session_start();

    if(!isset($_SESSION["id"])){
        header("Location ../");
    }

    if($_POST["password"] != $_POST["verify_password"]){
        header("Location: ../mi_cuenta");
    }else{
        $sql = $conn->prepare("UPDATE usuario SET clave = :nueva_clave WHERE id_usuario = :id");
        $sql->bindValue(":nueva_clave", password_hash($_POST["password"], PASSWORD_DEFAULT));
        $sql->bindValue(":id", $_SESSION["id"]);
        $sql->execute();

        $origenNombre="Tu banco";
        $origenEmail='no-reply@banco.jddma.com';
        $header = "From: " . $origenNombre . " <" . $origenEmail . ">\r\n";
        $mensaje = "Estimado(a) ". $_SESSION["apellidos"]. " ". $_SESSION["nombres"]. " su contraseña ha sido actualizada correctamente.\nGracias por usar Tu Banco.";
        mail($_POST["mail"], "Contraseña de respaldo", $mensaje, $header);
        require "cerrar_sesion.php";
        header("Location: ../?nueva_clave=true");
    }
?>
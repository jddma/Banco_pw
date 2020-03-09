<?php
    function generarClave(){
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $nueva_clave = "";
        for($i=0; $i<8;$i++){
            $nueva_clave .= substr($str,rand(0,62),1);
        }
        return $nueva_clave;
    }

    require "database.php";
    $sql = $conn->prepare("SELECT correo FROM usuario WHERE correo = :correo");
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $sql->bindValue(":correo", $_POST["mail"]);
    $sql->execute();

    while($columna = $sql->fetch()){
        if($columna["correo"] == $_POST["mail"]){
            session_start();
            $clave_respaldo = generarClave();
            $mensaje = "Estimado usuario hemos restablecido su contraseña. Esta nueva contraseña es de carácter 
            provisional, por lo que le recomendamos cambiarla desde la configuración de su cuenta. Nueva contraseña: ". 
            $clave_respaldo. "\nGracias por usar Tu Banco.";
            $origenNombre="Tu banco";
            $origenEmail='no-reply@banco.jddma.com';
            $header = "From: " . $origenNombre . " <" . $origenEmail . ">\r\n";
            
            $insert = $conn->prepare("UPDATE usuario SET clave = :nueva_clave WHERE correo = :correo");
            $insert->bindValue(":nueva_clave", password_hash($clave_respaldo, PASSWORD_DEFAULT));
            $insert->bindValue(":correo", $_POST["mail"]);
            $insert->execute();
            mail($_POST["mail"], "Contraseña de respaldo", $mensaje, $header);
            header("Location: ../?nueva_clave=true");
        }
    }

?>
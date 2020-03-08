<?php

    if($_POST["password"] != $_POST["verify_password"]){
        header("Location: ../nueva_clave/");
    }else{
        require "database.php";
        $sql = "UPDATE clave SET clave = :nueva_clave WHERE correo = :correo";
        $sql = $conn->prepare($sql);
        $sql->bindValue(":correo", $_POST["mail"]);
        $sql->bindValue(":nueva_clave", password_hash($_POST["password"], PASSWORD_DEFAULT));
        $sql->execute();
    }
?>
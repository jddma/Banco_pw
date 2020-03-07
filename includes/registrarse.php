<?php

    if(! isset($_POST["name"]))
    {
        header("Location: ../registrarse");
        exit();
    }

    $email=htmlentities($_POST["email"]);
    if(! filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        header("Location: ../registrarse?email_valido=false");
        exit();
    }
    else if($_POST["password"] != $_POST["verify_password"])
    {
        header("Location: ../registrarse/?pwd=false");
        exit();
    }
    else
    {
        require_once "database.php";

        $sql="SELECT id_usuario FROM usuario WHERE correo= :correo";
        $result=$conn->prepare($sql);
        $result->bindValue(":correo", $email);
        $result->execute();
        if($result->rowCount() > 0)
        {
            header("Location: ../?existente=true");
            exit();
        }

        $sql="INSERT INTO usuario (nombres, apellidos, no_documento, correo, clave) VALUES (:nombres, :apellidos, :no_documento, :correo, :clave)";
        $result=$conn->prepare($sql);
        $result->bindValue(":nombres",$_POST["name"]);
        $result->bindValue(":apellidos",$_POST["last_name"]);
        $result->bindValue(":no_documento",$_POST["document"]);
        $result->bindValue(":correo",$_POST["email"]);
        $result->bindValue(":clave", password_hash($_POST["password"], PASSWORD_DEFAULT));
        $result->execute();

        header("Location: ../?registro=true");

    }

?>
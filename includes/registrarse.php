<?php

    //en caso de que se intente acceder a este script sin haber llenado el formulario
    if(! isset($_POST["name"]))
    {
        header("Location: ../registrarse");
        exit();
    }

    $email=htmlentities($_POST["email"]);

    /**validar que el correo ingresado por el usuario sea valido
     *en caso de no serlo se le redirigira a la zona de registro nuevamente en caso de no serlo se le redirigira a la zona de registro nuevamente
     */
    if(! filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        header("Location: ../registrarse?email_valido=false");
        exit();
    }
    /**
     * valida que las contraseñas ingresadas por el usuario coincidan
     * en caso de no hacerlo se le redirigira a la zona de registro nuevamente
     */
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
        /**
         * esta condicional evalua si el correo ingresado por el usaurio ya se 
         * encuantra registrado en la base de datos; en caso de ser asi se lo
         * redirigira a la zona de login
         */
        if($result->rowCount() > 0)
        {
            header("Location: ../?existente=true");
            exit();
        }

        //si el script se ejecuta en este punto se pasa a insertar el nuevo usuario en la base de datos
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
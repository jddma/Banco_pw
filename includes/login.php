<?php

    //en caso de que se intente acceder a este script sin haber llenado el formulario
    if(! isset($_POST["email"]))
    {
        header("Location: ../");
        exit();
    }

    require_once "database.php";

    $sql="SELECT id_usuario, nombres, apellidos, correo, clave FROM usuario WHERE correo= :correo";
    $result=$conn->prepare($sql);
    $result->bindParam(":correo",$_POST["email"]);
    $result->execute();

    //en caso de que el usaurio no se encuentre resgistrado en la base de datos sera devuelto
    if($result->rowCount() == 0)
    {
        header("Location: ../?usuario=false");
        exit();
    }

    /**
     * si este ciclo se ejecuta el usuario ingresado existe y se obtiene la informacion
     * de la base de datos
     */
    while ($rows=$result->fetch(PDO::FETCH_ASSOC))
    {
        /**
         * esta consicional evalua si la contraseña ingresada por el usuario y
         * la que esta registrada en la base de datos coinciden
         */
        if (password_verify($_POST["password"], $rows["clave"] ))
        {
            /**
             * en caso de coincider se almacena la informacion pertinente del usuario
             * en la sesion y se le redirige a la zona reservada para usaurios regitrados panel
             */
            session_start();
            $_SESSION["id"]=$rows["id_usuario"];
            $_SESSION["apellidos"]=$rows["apellidos"];
            $_SESSION["nombres"]=$rows["nombres"];
            $_SESSION["correo"]=$rows["correo"];
            $_SESSION["documento"]=$rows["no_documento"];
            header("Location: ../panel/");
            exit();
        }
    }

    /**en caso de ejecutarse estas lineas quiere decir que la clave ingresada por 
     * el usuario no coincide con la que esta registrada e la base de datos
     */
    header("Location: ../?pwd=false");
    exit();  

?>
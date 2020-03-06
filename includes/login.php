<?php

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

    if($result->rowCount() == 0)
    {
        header("Location: ../");
        exit();
    }

    while ($rows=$result->fetch(PDO::FETCH_ASSOC))
    {
        if (password_verify($_POST["password"], $rows["clave"] ))
        {
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

    header("Location: ../");
    exit();  

?>
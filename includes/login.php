<?php

    if(! isset($_POST["email"]))
    {
        header("Location: ../");
        exit();
    }

    require_once "database.php";

    $sql="SELECT id_usuario, nombres, apellidos, correo, clave FROM usuario WHERE correo= :correo";
    $result=$conn->prepare($sql);
    $result->bindParam(":correo",$_POST["correo"]);
    $result->execute();

    if($result->rowCount() == 0)
    {
        header("Location: ../");
        exit();
    }

    while ($rows=$result->fetch(PDO::FETCH_ASSOC) 
    {
        $clave=rows["clave"];
        $correo=rows["correo"];
        $nombres=rows["nombres"];
        $apellidos=rows["apellidos"];
        $id=rows["id_usuario"];
        break;
    }

    if (password_verify($_POST["password"], $clave ))
    {
        session_start();
        $_SESSION["correo"]=$correo;
        $_SESSION["nombres"]=$nombres;
        $_SESSION["apellidos"]=$apellidos;
        $_SESSION["id"]=$id;
    }
    else
    {
        header("Location: ../");
        exit();
    }

?>
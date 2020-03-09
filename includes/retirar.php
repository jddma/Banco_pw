<?php

    /***
     * en caso de que se quiera ingresar sin haber iniciado sesion
     * * */
    session_start();
    if(! isset($_SESSION["id"]))
    {
        header("Location: ../");
        exit();
    }
    
    //en caso de que se intente acceder a este script sin haber llenado el formulario
    if(! isset($_POST["origen"]))
    {
        header("Location: ../retirar/");
        exit();
    }

    require "database.php";

    $sql="SELECT numero_producto, saldo FROM productos WHERE numero_producto= :numero_producto AND id_usuario= :id_usuario";
    $result=$conn->prepare($sql);
    $result->bindValue(":numero_producto", $_POST["origen"]);
    $result->bindValue(":id_usuario", $_SESSION["id"]);
    $result->execute();
    /**
     * esta condicional evalua si la cuenta de origen ingresada por el usuario existe 
     * y le pertenezca al usuario con la sesion abierta
     */
    if($result->rowCount() == 0)
    {
        header("Location: ../retirar/?origen=false");
        exit();
    }

    /**
     * si la cuenta de origen existe se procede a almacenar sus datos
     */
    while ($rows=$result->fetch(PDO::FETCH_ASSOC))
    {
        $saldo_actual=$rows["saldo"];
        $cuenta=$rows["numero_producto"];
    }

    /**
     * se verifica que el saldo de la cuenta de origen sea el suficiente
     * para realizar el retiro
     * */
    if($saldo_actual < $_POST["valor"])
    {
        header("Location: ../retiros/?monto=false");
        exit();
    }

    /**
     * se procede a restar el saldo retirado a la cuenta de origen
     */
    $saldo_final=$saldo_actual-$_POST["valor"];
    $sql="UPDATE productos SET saldo= :saldo_final WHERE numero_producto= :numero_producto";
    $result=$conn->prepare($sql);
    $result->bindValue(":saldo_final", $saldo_final);
    $result->bindValue(":numero_producto", $cuenta);
    $result->execute();

    header("Location: ../panel/?retiro=true");
    exit();

?>
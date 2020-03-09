<?php

    //en caso de que se intente acceder a este script sin haber llenado el formulario
    if(!isset($_POST["destino"]))
    {
        header("Location: ../consignaciones/");
        exit();
    }

    require "database.php";

    $sql="SELECT saldo FROM productos WHERE numero_producto= :numero_producto";
    $result=$conn->prepare($sql);
    $result->bindValue(":numero_producto", $_POST["destino"]);
    $result->execute();

    /**
     * validar que la cuenta de destino exista
     */
    if($result->rowCount() == 0)
    {
        header("Location: ../consignaciones?origen=false");
        exit();
    }

    //atrapar y almacenar el saldo de la cuenta destino
    while ($rows=$result->fetch(PDO::FETCH_ASSOC))
    {
        $saldo_actual=$rows["saldo"];
    }
    //calcular el saldo resultante de la cuenta de origen
    $saldo_final=$saldo_actual+$_POST["valor"];

    //actualizar el saldo de la cuenta de destino
    $sql="UPDATE productos SET saldo= :saldo_final WHERE numero_producto= :numero_producto";
    $result=$conn->prepare($sql);
    $result->bindValue(":saldo_final", $saldo_final);
    $result->bindValue(":numero_producto", $_POST["destino"]);
    $result->execute();

    header("Location: ../panel?consignacion=true");
    exit();

?>
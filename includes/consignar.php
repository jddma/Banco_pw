<?php

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
    if($result->rowCount() == 0)
    {
        header("Location: ../consignaciones?origen=false");
        exit();
    }

    while ($rows=$result->fetch(PDO::FETCH_ASSOC))
    {
        $saldo_actual=$rows["saldo"];
    }
    $saldo_final=$saldo_actual+$_POST["valor"];

    $sql="UPDATE productos SET saldo= :saldo_final WHERE numero_producto= :numero_producto";
    $result=$conn->prepare($sql);
    $result->bindValue(":saldo_final", $saldo_final);
    $result->bindValue(":numero_producto", $_POST["destino"]);
    $result->execute();

    header("Location: ../?consignacion=true");
    exit();

?>
<?php

    if(! isset($_POST["origen"]))
    {
        header("Location: ../retirar/");
        exit();
    }

    require "database.php";

    $sql="SELECT numero_producto, saldo FROM productos WHERE numero_producto= :numero_producto";
    $result=$conn->prepare($sql);
    $result->bindValue(":numero_producto", $_POST["origen"]);
    $result->execute();
    if($result->rowCount() == 0)
    {
        header("Location: ../retirar/");
        exit();
    }

    while ($rows=$result->fetch(PDO::FETCH_ASSOC))
    {
        $saldo_actual=$rows["saldo"];
        $cuenta=$rows["numero_producto"];
    }

    if($saldo_actual < $_POST["valor"])
    {
        header("Location: ../retiros/");
        exit();
    }

    $saldo_final=$saldo_actual-$_POST["valor"];
    $sql="UPDATE productos SET saldo= :saldo_final WHERE numero_producto= :numero_producto";
    $result=$conn->prepare($sql);
    $result->bindValue(":saldo_final", $saldo_final);
    $result->bindValue(":numero_producto", $cuenta);
    $result->execute();

    header("Location: ../");
    exit();

?>
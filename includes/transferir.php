<?php

    if(! isset($_POST["destino"]))
    {
        header("Location: ../panel");
        exit();
    }

    require "database.php";

    $sql="SELECT numero_producto, saldo FROM productos WHERE numero_producto= :numero_producto";
    $result=$conn->prepare($sql);
    $result->bindValue(":numero_producto", $_POST["destino"]);
    $result->execute();
    if($result->rowCount() == 0)
    {
        header("Location: ../transferencias");
        exit();
    }

    while ($rows=$result->fetch(PDO::FETCH_ASSOC))
    {
        $valor_actual_destino=$rows["saldo"];
    }

    $sql="SELECT saldo FROM productos WHERE numero_producto= :numero_producto";
    $result=$conn->prepare($sql);
    $result->bindValue(":numero_producto", $_POST["origen"]);
    $result->execute();
    if($result->rowCount() == 0)
    {
        header("Location: ../transferencias");
        exit();
    }

    while ($rows=$result->fetch(PDO::FETCH_ASSOC))
    {
        $valor_actual_origen=$rows["saldo"];
    }

    if($valor_actual_origen < $_POST["valor"])
    {
        header("Location: ../transferencias");
        exit();
    }

    $valor_final_destino=$valor_actual_destino+$_POST["valor"];
    $valor_final_origen=$valor_actual_origen-$_POST["valor"];

    $sql="UPDATE productos SET saldo= :final_destino WHERE numero_producto= :numero_producto";
    $result=$conn->prepare($sql);
    $result->bindValue("final_destino", $valor_final_destino);
    $result->bindValue("numero_producto", $_POST["destino"]);
    $result->execute();

    $sql="UPDATE productos SET saldo= :final_origen WHERE numero_producto= :numero_producto";
    $result=$conn->prepare($sql);
    $result->bindValue("final_origen", $valor_final_origen);
    $result->bindValue("numero_producto", $_POST["origen"]);
    $result->execute();

    header("Location: ../");
    exit();


?>
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
    if(! isset($_POST["destino"]))
    {
        header("Location: ../panel");
        exit();
    }

    //validar que el usuario no ingrese valores negativos
    if($_POST["valor"] < 1)
    {
        header("Location: ../transferencias?negativo=true");
        exit();
    }

    require "database.php";

    $sql="SELECT numero_producto, saldo FROM productos WHERE numero_producto= :numero_producto";
    $result=$conn->prepare($sql);
    $result->bindValue(":numero_producto", $_POST["destino"]);
    $result->execute();
    /**
     * Verificar que la cuenta destino se encuentre registrada en la
     * base de datos
     */
    if($result->rowCount() == 0)
    {
        header("Location: ../transferencias?destino=false");
        exit();
    }

    /**
     * Atrapar el saldo de la cuenta destino para posteriormente adicionar el
     * valor cconsignado
     */
    while ($rows=$result->fetch(PDO::FETCH_ASSOC))
    {
        $valor_actual_destino=$rows["saldo"];
    }

    $sql="SELECT saldo FROM productos WHERE numero_producto= :numero_producto AND id_usuario= :id_usuario";
    $result=$conn->prepare($sql);
    $result->bindValue(":numero_producto", $_POST["origen"]);
    $result->bindValue(":id_usuario", $_SESSION["id"]);
    $result->execute();
    /**
     * validar que la cuenta de origen exista y pertenezca al usaurio
     */
    if($result->rowCount() == 0)
    {
        header("Location: ../transferencias?origen=false");
        exit();
    }

    //atrapar y almacenar el saldo de la cuenta de origen
    while ($rows=$result->fetch(PDO::FETCH_ASSOC))
    {
        $valor_actual_origen=$rows["saldo"];
    }

    /**
     * validar que el saldo de la cuenta de origen sea suficiente para realzar la
     * transferencia
     */
    if($valor_actual_origen < $_POST["valor"])
    {
        header("Location: ../transferencias?monto=false");
        exit();
    }

    /**
     * calcular el saldo que quedara en ambas cuentas despues de la transferencia
     */
    $valor_final_destino=$valor_actual_destino+$_POST["valor"];
    $valor_final_origen=$valor_actual_origen-$_POST["valor"];

    //actualiza el saldo de la cuenta de destino
    $sql="UPDATE productos SET saldo= :final_destino WHERE numero_producto= :numero_producto";
    $result=$conn->prepare($sql);
    $result->bindValue("final_destino", $valor_final_destino);
    $result->bindValue("numero_producto", $_POST["destino"]);
    $result->execute();

    //actualiza el saldo de la cuenta destino
    $sql="UPDATE productos SET saldo= :final_origen WHERE numero_producto= :numero_producto";
    $result=$conn->prepare($sql);
    $result->bindValue("final_origen", $valor_final_origen);
    $result->bindValue("numero_producto", $_POST["origen"]);
    $result->execute();

    /**
     * Enviar un correo de verificacion al usuario ed origen
     */
    session_start();
    $date=getdate();
    $year=$date["year"];
    $month=$date["mon"];
    $day=$date["mday"];
    $hour=$date["hours"];
    $minute=$date["minutes"];

    $origenNombre="Tu banco";
    $origenEmail='no-reply@banco.jddma.com';
    $destinatarioEmail=$_SESSION["correo"];
    $header = "From: " . $origenNombre . " <" . $origenEmail . ">\r\n";
    
    $asuntoEmail="Verificar transferecia";
    $mensaje="Señor " . $_SESSION["apellidos"] . " " . $_SESSION["nombres"] . " le informamos que se ha efectuado una transferencia"
              . " el día de hoy $day-$month-$year desde la dirección ip: " . $_SERVER["REMOTE_ADDR"]. "\nGracias por usar Tu Banco.";

    mail($destinatarioEmail, $asuntoEmail, $mensaje, $header);

    header("Location: ../panel/?transferencia=true");
    exit();

?>
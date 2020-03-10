<?php

    /**
     * en caso de que se quiera entrar a este script sin llenar
     * el formulario
     */
    if(! isset($_POST["tipo"]))
    {
        header("Location: ../crear_cuenta");
        exit();
    }

    session_start();
    /**
     * para devolver al usuario en caso de que quiera ingresar sin haber 
     * iniciado sesion
     *  */    
    if (! isset($_SESSION["id"]))
    {
        header("Location: ../");
        exit();
    }

    require "database.php";
    $sql="SELECT id_tipo_producto FROM tipo_producto WHERE nombre_tipo= :tipo";
    $result=$conn->prepare($sql);
    $result->bindValue(":tipo", $_POST["tipo"]);
    $result->execute();
    /**
     * en caso de que la variable enviada por el usuario no
     * corresponda a un tipo de cuenta
     */
    if($result->rowCount() == 0)
    {
        header("Location: ../crear_cuenta/");
        exit();
    }

    //atrapar el id del tipo de producto seleccionado
    while ($rows=$result->fetch(PDO::FETCH_ASSOC)) 
    {
        $id_tipo=$rows["id_tipo_producto"];
    }

    //la query retorna el ultimo numero de producto de la base de datos
    $sql="SELECT numero_producto FROM productos ORDER BY numero_producto DESC LIMIT 1";
    $result=$conn->prepare($sql);
    $result->execute();
    /**
     * en caso de que no se hayan creado productos iniciara con 
     * el valor por defecto, de lo contrario creara el numero de la cuenta 
     * siguiente
     */
    if($result->rowCount() == 0)
    {
        $nuevo_numero="1000001";
    }
    else
    {
        while ($rows=$result->fetch(PDO::FETCH_ASSOC)) 
        {
            $nuevo_numero=$rows["numero_producto"]+1;
        }
    }

    /**
     * insertar a la base de datos la nueva cuenta creada
     */
    $sql="INSERT INTO productos (numero_producto, id_usuario, id_tipo_producto) VALUES 
              ( :nuevo_numero, :id_usuario, :id_tipo_producto)";
    $result=$conn->prepare($sql);
    $result->bindValue(":nuevo_numero", $nuevo_numero);
    $result->bindValue(":id_usuario", $_SESSION["id"]);
    $result->bindValue("id_tipo_producto", $id_tipo);
    $result->execute();

    header("Location: ../panel/?nueva_cuenta=true");
    exit();

?>
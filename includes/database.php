<?php

    try
    {
        $conn=new PDO("mysql:host=185.201.11.107; dbname=u658245195_banco", "u658245195_banco", "TInLYPff");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (Exception $e)
    {
        die("Error: " .$e->getMessage());
    }

?>

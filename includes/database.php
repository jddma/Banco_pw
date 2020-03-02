<?php

    try
    {
        $conn=new PDO("mysql:127.0.0.1; dbname=u658245195_banco", "u658245195_banco", "TInLYPff");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (Exception $e)
    {
        die("Error: " .$e->getMessage());
    }

?>

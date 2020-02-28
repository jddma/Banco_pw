<?php

    try
    {
        $conn=new PDO("mysql:host=127.0.0.1; dbname=banco", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (Exception $e)
    {
        die("Error: " .$e->getMessage());
    }

?>
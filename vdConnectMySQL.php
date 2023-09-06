<?php
    $username = "root";
    $password = "";
    $host = "localhost";
    $database = "PHP";
    $connection = new mysqli($host, $username, $password, $database);

    if($connection->connect_error)
        die("connection is error");
    else
        var_dump($connection);
?>
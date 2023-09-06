<?php
    $username = "root";
    $password = "";
    $host = "localhost";
    $database = "PHP";

/*  //  mysqli
    $connection = new mysqli($host, $username, $password, $database);
    
    if($connection->connect_errno)
        die("connection is error");
    else
        echo "connection is success</br>";
    
    $sql = "SELECT * FROM customers";
    $query = $connection->query($sql1);
    
    while($row = $query1->fetch_assoc())
        echo $row["name"]."</br>";
*/

//  PDO
    $sql = "SELECT * FROM customers";
    
    try{
        $connection = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $query = $connection->prepare($sql);
        $query->execute();
        
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $item){
            var_dump($item);
            echo "</br>";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
?>
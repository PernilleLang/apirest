<?php
    $servername = "localhost";
    $database = "boeger";
    $username = "root";
    $password = "";
 
    try{
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Database connection successful";
    } catch(PDOException $e){
        // echo "Failed to connect to database: " . $e->getMessage();
    }
?>   
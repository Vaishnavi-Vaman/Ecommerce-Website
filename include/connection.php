<?php

    $serverName = "localhost";
    $userName = "root";
    $password = "";
    $database = "ecom";

    $conn = new mysqli($serverName, $userName, $password, $database);

    // if($conn->connect_error){
    //     die('Connection failed'.$conn->connect_error);
    // } else{
    //     echo 'Connection Success';
    // }
?>
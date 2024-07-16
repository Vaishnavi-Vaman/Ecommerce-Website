<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $file = $_FILES["image"];
    
    require_once '../include/connection.php';

    $src = $_POST['src'];
    $name = $_POST['name'];

  if(move_uploaded_file($_FILES['image']['tmp_name'], "../admin/assets/images/material/" . $name)){

    http_response_code(200);
    echo json_encode(array("message" => "File uploaded successfully."));

  } else{

    http_response_code(500);
    die(json_encode(array("error" => "Error moving uploaded file.")));
  }
}

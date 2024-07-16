<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $file = $_FILES["image"];
    
    require_once '../include/connection.php';
    $cid = $_POST['cid'];
    $src = $_POST['src'];

  $path_banner = time() . "." . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

  if(move_uploaded_file($_FILES['image']['tmp_name'], "../admin/assets/images/custom/" . $path_banner)){

    $res = mysqli_query($conn, "SELECT * FROM design_temp WHERE
        cc_id = '$cid' AND order_number = '$src'");

    if(mysqli_num_rows($res)>0){

        mysqli_query($conn, "UPDATE design_temp SET customer_design = '$path_banner', design_id = '0' WHERE
        cc_id = '$cid' AND order_number = '$src'"); 
    } else{

        mysqli_query($conn, "INSERT INTO design_temp 
            (customer_design, cc_id, order_number)
            VALUES('$path_banner', '$cid', '$src')");
    }

    http_response_code(200);
    echo json_encode(array("message" => "File uploaded successfully."));

  } else{

    http_response_code(500);
    die(json_encode(array("error" => "Error moving uploaded file.")));
  }
}

<?php
    require_once '../include/connection.php';
    $did = $_POST['did'];
    $cid = $_POST['cid'];
    $src = $_POST['src'];

    $res = mysqli_query($conn, "SELECT * FROM design_temp WHERE
        cc_id = '$cid' AND order_number = '$src'");
    
    if(mysqli_num_rows($res)>0){

        mysqli_query($conn, "UPDATE design_temp SET design_id = '$did', customer_design = '' WHERE
        cc_id = '$cid' AND order_number = '$src'"); 
    } else{

        mysqli_query($conn, "INSERT INTO design_temp 
            (design_id, cc_id, order_number)
            VALUES('$did', '$cid', '$src')");
    }
?>
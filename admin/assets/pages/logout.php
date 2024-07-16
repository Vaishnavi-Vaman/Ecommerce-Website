<?php

    session_start();
    $_SESSION['admin_id'] = "";
    $_SESSION['is_admin_login'] = false;

    unset($_SESSION['admin_id']);
    unset($_SESSION['is_admin_login']);

    echo "<script>location.href='../../index.php';</script>";
?>
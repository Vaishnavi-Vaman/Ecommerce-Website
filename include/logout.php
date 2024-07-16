<?php
session_start();

if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    $_SESSION['isLogin'] = "";
    $_SESSION['user_id'] = "";
    $_SESSION['user_name'] = "";

    unset($_SESSION['isLogin']);
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);

    echo "<script>location.href='../login.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Logout</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <script>
        $(document).ready(function() {
            Swal.fire({
                title: 'Are you sure you want to logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, logout!',
                cancelButtonText: 'No, stay logged in '
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "logout.php?confirm=yes";
                } else {
                    window.location.href = "../index.php";
                }
            });
        });
    </script>
</body>
</html>
<?php
// before login code
//    // session_start();

//     $_SESSION['isLogin'] = "";
//     $_SESSION['user_id'] = "";
//     $_SESSION['user_name'] = "";

//     unset($_SESSION['isLogin']);
//     unset($_SESSION['user_id']);
//     unset($_SESSION['user_name']);

//     echo "<script>location.href='../login.php';</script>"; 

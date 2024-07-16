<?php
    session_start();

    if(empty($_SESSION['is_admin_login'])){
        echo "<script>location.href='index.php';</script>";
    }

    require_once '../include/connection.php';
    require_once './assets/pages/admin-link.php';
    require_once './assets/pages/admin-header.php';

    $admin_id = 0;

    if(!empty($_SESSION['admin_id'])){
        $admin_id = $_SESSION['admin_id'];
    }

    if(isset($_POST['update'])){

        $opass = $_POST['opass'];
        $npass = $_POST['npass'];

        $resSetting = mysqli_query($conn, "SELECT * FROM login_master 
        WHERE login_id = '$admin_id'");

        if(mysqli_num_rows($resSetting)>0){

            $resSetting = mysqli_fetch_assoc($resSetting);
            
            if($opass == $resSetting['login_password']){

                if(mysqli_query($conn, "UPDATE login_master SET login_password = '$npass' 
                    WHERE login_id = '$admin_id'")){

                    echo "<script>iqwerty.toast.toast('Your password updated successfully.');</script>";
                }
                else{

                    echo "<script>iqwerty.toast.toast('Unable to update your password.');</script>";
                }

            } else{

                echo "<script>iqwerty.toast.toast('An invalid current password.');</script>";
            }
        }
        else{
            
            echo "<script>iqwerty.toast.toast('Unable to process your request.');</script>";
        }       
    } 
?>
    
        <div id="layoutSidenav">
            <?php

                require_once './assets/pages/admin-sidebar.php';
            ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid p-4">
                        <div class="row">
                        <div class="col-sm-12 col-lg-3 col-md-6"></div>
                            <div class="col-sm-12 col-lg-6 col-md-6 shadow p-lg-5 p-3 mt-5">
                                <span class="text-center h2">Change Password</span>
                                <form method="post" class="row">
                                    <div class="col-sm-12 col-lg-12 col-md-12 mt-4">
                                        <label class="form-label">Current Password</label>
                                        <input type="password" class="form-control" required name="opass">
                                    </div>
                                    <div class="col-sm-12 col-lg-12 col-md-12 mt-3">
                                        <label class="form-label">New Password</label>
                                        <input type="password" class="form-control" name="npass" required pattern=".{6,}" title="Password must be 6 or more characters">
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button class="btn btn-primary" type="submit" name="update">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12 col-lg-3 col-md-6"></div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    
<?php

    require_once './assets/pages/admin-footer.php';
?>

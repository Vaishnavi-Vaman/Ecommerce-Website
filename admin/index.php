<?php
    session_start();

    if(!empty($_SESSION['is_admin_login'])){
        if($_SESSION['is_admin_login']){
            echo "<script>location.href='home.php';</script>";
        }
    }

    require_once './assets/pages/admin-link.php';
    require_once '../include/connection.php';

    if(isset($_POST['login'])){

        $password = $_POST['password'];
        $email = $_POST['email'];

        $res = mysqli_query($conn, "SELECT * FROM login_master 
            WHERE user_email_id = '$email' AND login_password = '$password' AND user_type = 'Admin'");

        if (mysqli_num_rows($res)>0) {

            $row = mysqli_fetch_assoc($res);

            $_SESSION['admin_id'] = $row['login_id'];
            $_SESSION['is_admin_login'] = true;

            echo "<script>location.href='home.php';</script>";          
        }
        else{

            echo "<script>iqwerty.toast.toast('An invalid credentials you have entered!.');</script>";
        }
    }

?>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 pt-5">
                            <div class="card mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body p-4">
                                    <form method="POST">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" type="email" name="email" required placeholder="Email Id"/>
                                            <label>Email Id</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" type="password" name="password" required placeholder="Password"/>
                                            <label>Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" ></a>
                                            <button type="submit" class="btn btn-primary" name="login">Login</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
<?php

    require_once './assets/pages/admin-footer.php';
?>

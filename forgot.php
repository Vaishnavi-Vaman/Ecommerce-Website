<?php

    session_start();

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    if(!empty($_SESSION['isLogin'])){
        
        echo "<script>location.href='index.php';</script>";
    }

    require_once 'include/connection.php';
    require_once 'include/keywords.php';
                                            
    if(isset($_POST['reset'])){

        $res = mysqli_query($conn, "SELECT lm.login_password, um.user_name FROM login_master lm, user_master um 
          WHERE lm.user_email_id = um.user_email_id AND lm.user_type = 'User' AND um.user_email_id = '$_POST[email]'");
        if(mysqli_num_rows($res)>0){

            $res = mysqli_fetch_assoc($res);

            $title = $site;
            $name = $res['user_name'];
            $password = $res['login_password'];
            $email = $_POST['email'];

            require 'vendor-email/autoload.php';

            $mail = new PHPMailer();
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->IsHTML(true);

            $mail->Username = 'vaishnavisirsat97@gmail.com';
            $mail->Password = 'ceql vtil rysj vebp';

            $mail->setFrom('vaishnavisirsat97@gmail.com', $title);
            $mail->addReplyTo('vaishnavisirsat97@gmail.com', $title);

            $mail->addAddress($email, $name);

            $mail->Subject = 'Password Reset Email - '.$title;
            $mail->Body = 'Dear '.$name.'<br> You recently requested reset your password<br> Password : '.$password.'<br><br> Thank you<br>Team '.$title;

            if ($mail->send()) {

                echo "<script type='text/javascript'>alert('Password has been sent to your registered email address!')</script>";
            } else {

                echo "<script type='text/javascript'>alert('Unable to process!')</script>";
            } 


        } else{

            echo "<script type='text/javascript'>alert('Email id not found!')</script>";
        }
        
	  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  
</head>
<body>
<section class="vh-100" style="background-color: #4c569c;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-6">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-12 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <form method="POST">

                  <div class="d-flex align-items-center mb-3 pb-1">
                    <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                    <span class="h1 fw-bold mb-0">Forgot Password</span>
                  </div>
                  <div class="form-outline my-4">
                    <label class="form-label" for="form2Example17">Email address</label>
                    <input type="email" id="form2Example17" class="form-control form-control-lg" name="email" required/>
                  </div>

                  <div class="pt-1 mb-4">
                    <button class="btn btn-dark btn-lg btn-block" type="submit" name="reset">Reset</button>
                  </div>
                  
                  <p style="color: #393f81;">Remember your password? <a href="login.php"
                      style="color: #393f81;">Login here</a></p>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  
</body>
</html>
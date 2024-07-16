<?php

    session_start();

    if(!empty($_SESSION['isLogin'])){
        
        echo "<script>location.href='index.php';</script>";
    }

    require_once 'include/connection.php';
                                            
    if(isset($_POST['register'])){

        $res = mysqli_query($conn, "SELECT user_id FROM user_master WHERE user_email_id = '$_POST[email]' AND user_status = 1");

        if(mysqli_num_rows($res)>0){

            echo "<script>alert('Oops, Email id already exists!')</script>'";                
        } else{

          if(mysqli_query($conn, "INSERT INTO user_master (user_name, user_email_id,  
              user_status, user_date_create, user_phone_number) VALUES ('$_POST[name]', 
              '$_POST[email]', 1, NOW(), '$_POST[phone]')")){

            if(mysqli_query($conn, "INSERT INTO login_master (user_email_id, login_password, date_create, user_type) VALUES (
                '$_POST[email]', '$_POST[password]', NOW(), 'User')")){
                  
                  $_SESSION['isLogin']  = true;
                  $_SESSION['user_id'] = mysqli_insert_id($conn);
                  $_SESSION['user_name'] = $_POST['name'];
          
                  echo "<script>location.href='index.php'</script>";
            }  else{

              echo "<script>alert('Unable to process your request!')</script>";
            }
          }else{

            echo "<script>alert('Unable to process your request!')</script>";
          }
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
              <div class="card-body p-4 px-lg-5 py-lg-4 text-black">

                <form method="POST">

                  <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                    <span class="h2 fw-bold mb-0">Registration</span>
                  </div>
                  <div class="form-outline my-3">
                    <label class="form-label" for="form2Example17">Full Name</label>
                    <input type="text" id="form2Example17" class="form-control form-control-lg" name="name" required  pattern="^([A-Za-z]+[ ]?|[A-Za-z])+$" title="Only alphabets and space are allowed."/>
                  </div>

                  <div class="form-outline my-3">
                    <label class="form-label" for="form2Example17">Email address</label>
                    <input type="email" id="form2Example17" class="form-control form-control-lg" name="email" required/>
                  </div>

                  <div class="form-outline my-3">
                    <label class="form-label" for="form2Example17">Phone Number</label>
                    <input type="text" id="form2Example17" class="form-control form-control-lg" name="phone" required pattern="[0-9]{10}" title="Accept 10 digit numbers only."/>
                  </div>

                  <div class="form-outline mb-3">
                    <label class="form-label" for="form2Example27">Password</label>
                    <input type="password" id="form2Example27" class="form-control form-control-lg" name="password" required minlength="6" title="Must contain at least 6 or more characters"/>
                  </div>

                  <div class="pt-1 mb-3">
                    <button class="btn btn-dark btn-lg btn-block float-start" type="submit" name="register">Register</button>
                    <p class="float-end" style="color: #393f81;">Already have an account? <a href="login.php"
                      style="color: #393f81;">Login here</a></p>
                  </div>

                  <!-- <a class="small text-muted" href="#!">Forgot password?</a> -->
                 
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
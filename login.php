<?php

    session_start();

    if(!empty($_SESSION['isLogin'])){
        
        echo "<script>location.href='index.php';</script>";
    }

    require_once 'include/connection.php';
                                            
    if(isset($_POST['login'])){

		$res = mysqli_query($conn, "SELECT um.user_id, um.user_name FROM user_master um, login_master lm 
		  WHERE lm.user_email_id = um.user_email_id AND lm.user_email_id = '$_POST[email]' 
		  AND lm.login_password = '$_POST[password]' AND lm.user_type = 'User'");
  
		if(mysqli_num_rows($res)>0){
  
			$row = mysqli_fetch_assoc($res);

			$_SESSION['isLogin']  = true;
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['user_name'] = $row['user_name'];

      if(!empty($_GET['source'])){

        if($_GET['source']=='payment'){

          echo "<script>location.href='payment.php'</script>";
        } else if($_GET['source']=='settings'){

          echo "<script>location.href='settings.php'</script>";
        } else if($_GET['source']=='profile'){

          echo "<script>location.href='profile.php'</script>";
        }else if($_GET['source']=='orders'){

          echo "<script>location.href='orders.php'</script>";
        }else{

          echo "<script>location.href='index.php'</script>";
        }
      } else{

          echo "<script>location.href='index.php'</script>";
      }
  
		  	
  
		} else{
		  echo "<script type='text/javascript'>alert('An invalid credentials you have entered!')</script>";
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
            <div class="col-md-12 col-lg-12 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <form method="POST">

                  <div class="d-flex align-items-center mb-3 pb-1">
                    <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                    <span class="h1 fw-bold mb-0">Login Here</span>
                  </div>
                  <div class="form-outline my-4">
                    <label class="form-label" for="form2Example17">Email address</label>
                    <input type="email" id="form2Example17" class="form-control form-control-lg" name="email" required/>
                  </div>

                  <div class="form-outline mb-4 position-relative">
                    <label class="form-label" for="form2Example27">Password</label>
                    <input type="password" id="password" class="form-control form-control-lg" name="password" required/>
                    <i class="fa fa-eye position-absolute" id="togglePassword" style="top: 45px; right: 15px; cursor: pointer;"></i>
                  </div>
                  <div class="pt-1 mb-4">
                    <button class="btn btn-dark btn-lg btn-block" type="submit" name="login">Login</button>
                  </div>

                  <p class="mb-3 text-end" style="color: #393f81;">Forgot Password? <a href="forgot.php"
                      style="color: #393f81;">Reset here</a></p>
                  
                  <p style="color: #393f81;">Don't have an account? <a href="register.php"
                      style="color: #393f81;">Register here</a></p>
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
<?php
// Include config file
session_start();
require_once "config.php";
$success = "";
$error_message = "";
$success_admin = "";



if($_SERVER["REQUEST_METHOD"] == "POST")
{
  if(isset($_POST["submit_mail"]))
  {
    if(isset($_POST['reset-username']) && isset($_POST['reset-mail']))
    {

                $response = array();
                $username = $_POST['reset-username'];
                $mail = $_POST['reset-mail'];
                $_SESSION["usermail"] = $mail;
                $result1 = mysqli_query($link,"SELECT * FROM users WHERE email ='$mail' AND username='$username'");

                 if(mysqli_num_rows($result1) > 0)
                 {
                              $otp = rand(100000,999999);
                              // Send OTP
                              require_once("mail_function_admin.php");
                              $mail_status = sendOTP($mail,$otp);

                              if($mail_status == 1)
                              {
                                  $result = mysqli_query($link,"INSERT INTO otp_expiry(otp,is_expired,created_at) VALUES ('" . $otp . "', 0, '" . date("Y-m-d H:i:s"). "')");
                                  if($result)
                                  {
                                      $success=1;
                                      $success_admin = $username;
                                      $_SESSION["success_admin"] = $username;
                                  }
                              }
                              // else {
                              //   echo '<script type="text/javascript">';
                              //   echo 'alert("mail not sent");';
                              //   echo 'window.location.href = "reset.php";';
                              //   echo '</script>';
                              // }


                 }
                 else
                 {
                                $error_message = "Data Not Found";
                                $response["success"] = 0;
                                $response["message"] = "Data Not Found";
                                echo '<script type="text/javascript">';
                                echo 'alert("Data Not Found");';
                                echo 'window.location.href = "reset.php";';
                                echo '</script>';



                 }


    }
  }


  if(isset($_POST["submit_otp"]))
  {
    if(isset($_POST['otp']))
    {

                $response = array();
                $otp = $_POST['otp'];
                $result1 = mysqli_query($link,"SELECT * FROM otp_expiry WHERE otp='$otp' AND is_expired!=1 AND NOW() <= DATE_ADD(created_at, INTERVAL 24 HOUR)");

                 if(mysqli_num_rows($result1) > 0)
                 {
                   $result2 = mysqli_query($link,"UPDATE otp_expiry SET is_expired = 1 WHERE otp = '$otp'");
               		 $success = 2;

                 }
                 else
                 {
                                $success = 1;
                                $error_message = "Invalid OTP";
                                $response["success"] = 0;
                                $response["message"] = "Invalid OTP";
                                // echo '<script type="text/javascript">';
                                // echo 'alert("Invalid OTP");';
                                // echo 'window.location.href = "reset.php";';
                                // echo '</script>';



                 }


    }
  }

  if(isset($_POST["submit_pass"]))
  {
    if(isset($_POST['reset-password']) && isset($_POST['reset-confirm']) )
    {

                $response = array();
                $password = $_POST['reset-password'];
                $confirm_password = $_POST['reset-confirm'];
                $reset_user = $_SESSION["success_admin"];
                $usermail = $_SESSION["usermail"];
                if($password == $confirm_password)
                {
                  $pass = password_hash($password,PASSWORD_DEFAULT);
                  $result = mysqli_query($link,"UPDATE users SET password = '$pass' WHERE username = '$reset_user'");
                  if($result)
                  {
                    $response["success"] = 1;
                    $response["message"] = "Password Changed Successfully";
                    require_once("mail_function_admin.php");
                    $mail_status = sendUpdateNotif($usermail,$reset_user,$password);
                    $success = "";
                    $error_message = "";
                    $success_admin = "";
                    $_SESSION = array();
                    session_destroy();
                    echo '<script type="text/javascript">';
                    echo 'alert("Password Changed Successfully");';
                    echo 'window.location.href = "login.php";';
                    echo '</script>';
                  }

                }
                else
                {
                  $error_message = "Passwords Don't Match";
                  $response["success"] = 0;
                  $response["message"] = "Passwords Don't Match";
                  $success = 2;
                }



    }

  }







mysqli_close($link);
// header("location: welcome.php");
}


 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EEKI Admin Password Reset</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <style type="text/css">
    body {
      color: #fff;
      background: #4c535d;
      font-family: 'Roboto', sans-serif;
    }
      .form-control {
          min-height: 41px;
      box-shadow: none;
      border-color: #e1e4e5;
    }
      .form-control:focus {
      border-color: #5fcaba;
    }
      .form-control, .btn {
          border-radius: 3px;
      }
    .signup-form {
      width: 400px;
      margin: 0 auto;
      padding: 30px 0;
    }
      .signup-form form {
      color: #9ba5a8;
      border-radius: 3px;
        margin-bottom: 15px;
          background: #fff;
          box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
          padding: 30px;
      }
    .signup-form h2 {
      color: #333;
      font-weight: bold;
          margin-top: 0;
      }
      .signup-form hr {
          margin: 0 -30px 20px;
      }
    .signup-form .form-group {
      margin-bottom: 20px;
    }
      .signup-form label {
      font-weight: normal;
      font-size: 13px;
    }
      .signup-form .btn {
          font-size: 16px;
          font-weight: bold;
      background: #5fcaba;
      border: none;
      min-width: 140px;
      }
    .signup-form .btn:hover, .signup-form .btn:focus {
      background: #3fc0ad;
          outline: none !important;
    }
    .signup-form a {
      color: #fff;
      text-decoration: underline;
    }
      .signup-form a:hover {
      text-decoration: none;
    }
    .signup-form form a {
      color: #5fcaba;
      text-decoration: none;
    }
    .signup-form form a:hover {
      text-decoration: underline;
    }
    </style>
</head>
<body>
    <div class="signup-form">
        <h2>EEKI Admin User password Reset</h2>
        <p></p>
        <!-- <form action="" method="post"> -->
          <form action="" method="post">
          <?php
      			if($success == 1)
             {
      		?>
            <div class="form-group">
                <label>Enter OTP</label>
                <p>Check Your Mail For OTP</p>
                <input type="text" name="otp" class="form-control" placeholder="One Time Password" required>
                <input type="submit" name="submit_otp" value="Submit" class="btn btn-primary">
                <span class="help-block"><?php echo $error_message; ?></span>
            </div>
          <?php
              } else if ($success == 2)
              {
          ?>
          <div class="form-group">
              <label>New Password</label>
              <input type="password" name="reset-password" class="form-control" placeholder="New Password" required>
          </div>
          <div class="form-group">
              <label>Confirm Password</label>
              <input type="password" name="reset-confirm" class="form-control" placeholder="Confirm Password" required>
              <span class="help-block"><?php echo $error_message; ?></span>
          </div>
          <div class="form-group">
              <input type="submit" class="btn btn-primary" name="submit_pass" value="Submit">
          </div>

          <?php
      			  }
      			else
              {
      		?>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="reset-username" class="form-control" placeholder="Admin User" required>
            </div>
            <div class="form-group">
                <label>Email Id</label>
                <input type="text" name="reset-mail" class="form-control" placeholder="Admin user mail id" required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="submit_mail" value="Submit">
            </div>
          <?php
        			}
        	?>
        </form>
    </div>
</body>
</html>

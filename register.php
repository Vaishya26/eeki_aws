<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = $adminmail = "";
$username_err = $password_err = $confirm_password_err = $adminmail_err ="";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM superAdmin WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }


    // Validate adminmail
    if(empty(trim($_POST["adminmail"]))){
        $adminmail_err = "Please enter a email id";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM superAdmin WHERE email = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_adminmail);

            // Set parameters
            $param_adminmail = trim($_POST["adminmail"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $adminmail_err = "This email is already registered.";
                } else{
                    $adminmail = trim($_POST["adminmail"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($adminmail_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO superAdmin (username, email, password) VALUES (?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_adminmail, $param_password);

            // Set parameters
            $param_username = $username;
            $param_adminmail = $adminmail;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: superAdminLogin.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
	<title>EEKI Foods Super Admin Registration</title>
	<link rel="icon" href="https://eekifoods.com/wp-content/uploads/2020/05/cropped-favicon-32x32.png">
	<!-- Meta tag Keywords -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" />
	<meta name="keywords"
		content="Eekifoods, is founded by two IIT Bombay graduates with a vision to change how vegetables are grown and develop the eeki agritech platform which will work for decades to come" />
	<script>
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- //Meta tag Keywords -->
	<!--/Style-CSS -->
  <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <style media="screen">
  .w3l-login-6 .grid-info-form {
    top: 40% !important;
    left: 45%;
    text-align: center !important;
    color: #fff;
    transform: translate(-50%, -50%);
    max-width: 500px;
    margin: 0 auto;
    position: absolute;
    background-size: 100%;
  }
  .fa-linkedin-square {
      background: white;
      color: #007bb5;
                }
  .fa-envelope {
      background:white;
      color: #dd4b39;
             }
  .fa-facebook-official {
      background:white ;
      color: #3B5998;
           }
    .fa-instagram {
      background:white ;
      color: #125688;
       }

  .fa {
   padding: 20px;
   font-size: 30px;
   width: 50px;
   text-align: center;
   text-decoration: none;
              }
  </style>

	<!--//Style-CSS -->
</head>

<body>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
  <!-- Brand/logo -->
  <a class="navbar-brand" href="#">
    <img src="https://eekifoods.com/wp-content/uploads/2020/05/logo.png" alt="logo" style="width:100px;">
  </a>

  <!-- Links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="https://eekifoods.com">EEKI Foods</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="superAdminLogin.php">Super Admin Login</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="login.php">Admin Login</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="farmLogin.php">Farm Login</a>
    </li>
  </ul>
</nav>

	<!-- /login-section -->
	<section class="w3l-login-6">
		<div class="login-hny">
			<div class="form-content">
				<div class="form-right">
					<div class="overlay">
						<div class="grid-info-form">
							<!-- <h5>Say hello</h5> -->
							<h3>About Us</h3>
							<p>Eekifoods, is founded by two IIT Bombay graduates with a vision to change how vegetables are grown and develop the eeki agritech platform which will work for decades to come. Grow the best quality of vegetables there can be, throughout India. Vegetables are grown and sold locally under the brand name of “EEKI FOODS” in the city, providing traceability & authenticity as well as the “farm to fork” experience to the end-customers.
The objective is achieved by setting up farms with a farm-partner across on outskirts of major urban areas of India. These farms produce high-quality residue-free fruits and vegetables using our IOT enabled completely medium-less growing technology. “We are not consultants. We are growers, the technology enablers.”</p>
							<!-- <a href="index.html" class="read-more-1 btn">Visit Us</a> -->
							<h3>Contact Us</h3>
							<p>Email: info@eekifoods.com&nbsp;&nbsp;Phone: +91-916-794-1572<br>E-44 , Gyan Sarovar Colony&nbsp;&nbsp;Kota-Bundi Road<br>Kunhadi ,Kota, Rajasthan -324008</p>

						</div>


					</div>
				</div>
				<div class="form-left">
					<div class="middle">
						<h4>Super Admin Registration</h4>
						<p>Register here to as Super Admin</p>
					</div>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="signin-form">
							<div class="form-input <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
								<label>Name</label>
								<input type="text" name="username" placeholder="Username" required />
                <span class="help-block"><?php echo $username_err; ?></span>
							</div>
              <div class="form-input <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
								<label>Email Id</label>
								<input type="text" name="adminmail" placeholder="Email" required />
                <!-- <span class="help-block"><?php echo $username_err; ?></span> -->
							</div>
							<div class="form-input <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
								<label>Password</label>
								<input type="password" name="password" placeholder="Password" required />
                <span class="help-block"><?php echo $password_err; ?></span>
							</div>
              <div class="form-input <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
								<label>Confirm Password</label>
								<input type="password" name="confirm_password" placeholder="Confirm Password" required />
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
							</div>

							<label class="container">I Agree to the terms and conditions
								<input type="checkbox">
								<span class="checkmark"></span>
							</label>
							<button class="btn" type="submit">Register</button>
					</form>
					<div class="copy-right text-center">
            <p>Already have an account? <a href="login.php">Login Now</a>.</p>
						<p>© 2020 All rights reserved | Designed by EEKI Foods<a href="http://eekifoods.com" target="_blank"></a></p>
            <p><a href="https://www.linkedin.com/company/eekifoods/about/"><i class="fa fa-linkedin-square fa-lg" aria-hidden="true"></i></a>&nbsp;<a href="mailto:info@eekifoods.com"><i class="fa fa-envelope fa-lg" aria-hidden="true"></i></a>&nbsp;<a href="https://www.facebook.com/eekifoods/"><i class="fa fa-facebook-official fa-lg" aria-hidden="true"></i></a>&nbsp;<a href="https://instagram.com/eekifoods"><i class="fa fa-instagram fa-lg" aria-hidden="true"></i></a><p>
					 </div>
				</div>

			</div>

		</div>
	</section>
	<!-- //login-section -->
</body>

</html>

<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["superAdminLoggedin"]) || $_SESSION["superAdminLoggedin"] !== true){
    header("location: superAdminLogin.php");
    exit;
}

// Include config file
require_once "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

  if(isset($_POST['admin_username']) && isset($_POST['admin_password']) && isset($_POST['admin_mail']) && isset($_POST['submit_addAdmin']))
  {

              $response = array();
              $username = $_POST['admin_username'];
              $usermail = $_POST['admin_mail'];
              $pass = $_POST['admin_password'];
              $password = password_hash($pass, PASSWORD_DEFAULT); // Creates a password hash

              $result1 = mysqli_query($link,"SELECT * FROM users WHERE username ='$username'");

               if(mysqli_num_rows($result1) > 0)
               {

                             $response["success"] = 0;
                             $response["message"] = "Admin Already Exist";
                             echo '<script type="text/javascript">';
                             echo 'alert("Admin Already Exist");';
                             echo 'window.location.href = "superAdminWelcome.php";';
                             echo '</script>';
                             // echo json_encode($response);

               }
               else
               {
                  $result2 = mysqli_query($link,"INSERT INTO users(username,email,password) VALUES('$username','$usermail','$password')");
                        if ($result2)
                              {
                              $response["success"] = 1;
                              $response[$farmname] = "Admin added Successfully";
                              require_once("mail_function_admin.php");
                              $mail_status = sendNotif($usermail,$username,$pass);
                              echo '<script type="text/javascript">';
                              echo 'alert("Admin added Successfully");';
                              echo 'window.location.href = "superAdminWelcome.php";';
                              echo '</script>';

                              // echo json_encode($response);

                              }
                        else
                              {
                              $response["success"] = 0;
                              $response["message"] = "Failed to add admin";
                              echo '<script type="text/javascript">';
                              echo 'alert("Failed to add admin");';
                              echo 'window.location.href = "superAdminWelcome.php";';
                              echo '</script>';
                              // echo json_encode($response);
                              }


               }


  }

  if(isset($_POST['edit_admin_username']) && isset($_POST['edit_select_admin_username']) && isset($_POST['edit_admin_password']) && isset($_POST['edit_admin_mail']) && isset($_POST['submit_editAdmin']))
  {

              $response = array();
              $oldusername = $_POST['edit_select_admin_username'];
              $newusername = $_POST['edit_admin_username'];
              $usermail = $_POST['edit_admin_mail'];
              $pass = $_POST['edit_admin_password'];
              $password = password_hash($pass, PASSWORD_DEFAULT); // Creates a password hash

              $result1 = mysqli_query($link,"SELECT * FROM users WHERE username ='$oldusername'");

               if(mysqli_num_rows($result1) > 0)
               {

                 $result3 = mysqli_query($link,"UPDATE users SET username = '$newusername', password = '$password',email = '$usermail' WHERE username = '$oldusername'");
                       if ($result3)
                             {
                             $response["success"] = 1;
                             $response[$farmname] = "Admin successfully updated";
                             require_once("mail_function_admin.php");
                             $mail_status = sendUpdateNotif($usermail,$newusername,$pass);
                             echo '<script type="text/javascript">';
                             echo 'alert("Admin successfully updated");';
                             echo 'window.location.href = "superAdminWelcome.php";';
                             echo '</script>';
                             // echo json_encode($response);

                             }
                       else
                             {
                             $response["success"] = 0;
                             $response["message"] = "Failed to update admin";
                             echo '<script type="text/javascript">';
                             echo 'alert("Failed to update admin");';
                             echo 'window.location.href = "superAdminWelcome.php";';
                             echo '</script>';
                             // echo json_encode($response);
                             }


               }
               else
               {
                              $response["success"] = 0;
                              $response["message"] = "Admin dosen't exist";
                              echo '<script type="text/javascript">';
                              echo 'alert("Admin does not exist");';
                              echo 'window.location.href = "superAdminWelcome.php";';
                              echo '</script>';

                              // echo json_encode($response);

               }


  }

  if(isset($_POST['delete_admin']) && isset($_POST['submit_deleteAdmin']))
  {
    $response = array();
    $username = $_POST['delete_admin'];

    $result1 = mysqli_query($link,"SELECT * FROM users WHERE username ='$username'");

    if(mysqli_num_rows($result1) > 0)
    {

      $result2 = mysqli_query($link,"DELETE FROM users WHERE username='$username'");
            if ($result2)
                  {
                  $response["success"] = 1;
                  $response["message"] = "Admin Successfully Deleted";
                  echo '<script type="text/javascript">';
                  echo 'alert("Admin Successfully Deleted");';
                  echo 'window.location.href = "superAdminWelcome.php";';
                  echo '</script>';
                  // echo json_encode($response);

                  }
            else
                  {
                  $response["success"] = 0;
                  $response["message"] = "Failed to delete admin";
                  echo '<script type="text/javascript">';
                  echo 'alert("Failed to delete admin");';
                  echo 'window.location.href = "superAdminWelcome.php";';
                  echo '</script>';
                  // echo json_encode($response);
                  }


    }
    else
    {
                   $response["success"] = 0;
                   $response["message"] = "Admin Dosen't Exist";
                   echo '<script type="text/javascript">';
                   echo 'alert("Admin Does not Exist");';
                   echo 'window.location.href = "superAdminWelcome.php";';
                   echo '</script>';
                   // echo json_encode($response);

    }
  }



  if(isset($_POST['login_farm']))
  {
    $response = array();
    $farmid = $_POST['login_farm'];

    $result1 = mysqli_query($link,"SELECT * FROM farms WHERE farmId ='$farmid' limit 1");

    if(mysqli_num_rows($result1) > 0)
    {

      $row = mysqli_fetch_assoc($result1);
      // Redirect user to master page
      header("location: http://".$row['farmIp'].":".$row['farmPort']."/eekiAdminBoard?farm_id=".$row['farmId']."&farm_name=".$row['farmName']."&farm_user=".$_SESSION["superAdminLoggedinUsername"]."&farm_userType=admin");


    }
    else
    {
                   $response["success"] = 0;
                   $response["message"] = "Farm Dosen't Exist";
                   echo '<script type="text/javascript">';
                   echo 'alert("Farm Does not Exist");';
                   echo 'window.location.href = "superAdminWelcome.php";';
                   echo '</script>';
                   // echo json_encode($response);

    }
  }


mysqli_close($link);
// header("location: welcome.php");
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Welcome to EEKI Super Admin</title>
<link rel="icon" href="https://eekifoods.com/wp-content/uploads/2020/05/cropped-favicon-32x32.png">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<style type="text/css">
h2 {
   width: 100%;
   /* text-align: center; */
   text-indent: 200px;
   border-bottom: 1px solid #fff;
   line-height: 0.1em;
   margin: 10px 0 20px;
}

h2 span {
    background:#fff;
    border-radius: 5px;
    padding:0 10px;
}

	.btn-huge
  {
    padding-top:20px;
    padding-bottom:20px;
    width: 100%;
    /* height: 100%; */
  }
  .jumbotron
  {
    height:auto;
    padding:5px 0 !important;
  }


body {
		color: #fff;
		background: #333333;
		font-family: 'Roboto', sans-serif;
	}
  .modal-content {
    color: black;
  }

.btn-success,
.btn-success:hover,
.btn-success:active,
.btn-success:visited,
.btn-success:focus {
    background-color: #097479 !important;
    border-color: #FFFFFF !important;
}
.btn-success{
  font-size:13pt !important;
}

.btn-primary,
.btn-primary:hover,
.btn-primary:active,
.btn-primary:visited,
.btn-primary:focus {
    background-color: #097479 !important;
    border-color: #FFFFFF !important;
}


</style>
</head>
<body>

    <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold" style="color:black;" >Add Admin</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="modalBody">
          <div class="form-group row">
            <div class="col-sm-2"></div>
            <label class="col-form-label col-sm-3" style="color:black;">Username</label>
            <div class="col-sm-5">
              <input type="text" name="admin_username" id="admin_username" class="form-control" placeholder="admin Username" required>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-2"></div>
              <label class="col-form-label col-sm-3" style="color:black;">Password</label>
              <div class="col-sm-5">
                <input type="password" name="admin_password" id="admin_password" class="form-control" placeholder="admin Passoword" required>
              </div>
          </div>
            <div class="form-group row">
                <div class="col-sm-2"></div>
                <label class="col-form-label col-sm-3" style="color:black;">Email Id</label>
                <div class="col-sm-5">
                    <input type="text" name="admin_mail"  class="form-control" id="admin_password" placeholder="admin email-id" required>
                </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-5"></div>
                <input type="submit" class="btn btn-primary" name="submit_addAdmin" value="Add Admin">
            </div>
        </form>

      </div>

      <div class="modal-footer d-flex justify-content-center">

      </div>
    </div>
  </div>
</div>
<!-- end of modal for adding a farm -->



<div class="modal fade" id="modalLoginForm1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header text-center">
    <h4 class="modal-title w-100 font-weight-bold" style="color:black;" >Update Admin</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body mx-3">

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="modalBody">
      <div class="form-group row">
        <div class="col-sm-2"></div>
        <label class="col-form-label col-sm-3" style="color:black;">Select Admin</label>
        <div class="col-sm-5">
          <select name="edit_select_admin_username" id="edit_select_admin_username" class="form-control" style="text-align-last:center;" required>
                 <option value="">--- Select Admin ---</option>


                 <?php

                     $adminData = mysqli_query($link,"SELECT * from users");
                     while($row2 = $adminData->fetch_assoc()){
                         echo "<option value='".$row2['username']."'>".$row2['username']."</option>";
                     }
                 ?>


          </select>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-2"></div>
          <label class="col-form-label col-sm-3" style="color:black;">Update Admin</label>
          <div class="col-sm-5">
            <input type="text" name="edit_admin_username" id="edit_admin_username" class="form-control" placeholder="admin username" required>
          </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-2"></div>
          <label class="col-form-label col-sm-3" style="color:black;">Update Password</label>
          <div class="col-sm-5">
            <input type="password" name="edit_admin_password" id="edit_admin_password" class="form-control" placeholder="admin passowrd" required>
          </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-2"></div>
          <label class="col-form-label col-sm-3" style="color:black;">Update Email-Id</label>
          <div class="col-sm-5">
            <input type="text" name="edit_admin_mail" id="edit_admin_mail" class="form-control" placeholder="admin mail-id" required>
          </div>
      </div>
        <div class="form-group row">
          <div class="col-sm-5"></div>
            <input type="submit" class="btn btn-primary" name="submit_editAdmin" value="Update Admin">
        </div>
    </form>

  </div>

  <div class="modal-footer d-flex justify-content-center">

  </div>
</div>
</div>
</div>
<!-- end of modal for updating farm -->




<div class="modal fade" id="modalLoginForm2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header text-center">
    <h4 class="modal-title w-100 font-weight-bold" style="color:black;" >Delete Admin</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body mx-3">

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="modalBody">
      <div class="form-group row">
        <div class="col-sm-2"></div>
        <label class="col-form-label col-sm-3" style="color:black;">Select Admin</label>
        <div class="col-sm-5">
          <select name="delete_admin" id="delete_admin" class="form-control">
                 <option value="">--- Select Admin ---</option>


                 <?php

                 $adminData = mysqli_query($link,"SELECT * from users");
                 while($row2 = $adminData->fetch_assoc()){
                     echo "<option value='".$row2['username']."'>".$row2['username']."</option>";
                 }
                 ?>


          </select>
        </div>
      </div>

        <div class="form-group row">
          <div class="col-sm-5"></div>
            <input type="submit" class="btn btn-primary" name="submit_deleteAdmin" value="Delete Admin">
        </div>
    </form>

  </div>

  <div class="modal-footer d-flex justify-content-center">

  </div>
</div>
</div>
</div>
<!-- end of modal for deleting farm -->











<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <!-- <a class="navbar-brand" href="#"><img src="https://eekifoods.com/wp-content/uploads/2020/05/logo.png" alt="logo" style="width:100px;"></a> -->
    <img src="https://eekifoods.com/wp-content/uploads/2020/05/logo.png" alt="logo" style="width:100px;">
    </div>
    <ul class="nav navbar-nav">
      <li class=""><a href="#"><span class="glyphicon glyphicon-home"></span> Home</a></li>
      <!--<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>-->
      <!--  <ul class="dropdown-menu">-->
      <!--    <li><a href="#">Page 1-1</a></li>-->
      <!--    <li><a href="#">Page 1-2</a></li>-->
      <!--    <li><a href="#">Page 1-3</a></li>-->
      <!--  </ul>-->
      <!--</li>-->
      <!--<li><a href="#">Page 2</a></li>-->
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="farmLogin.php"><span class="glyphicon glyphicon-user"></span><b>Farm Login</b></a></li>
      <li class="active"><a href="#"><span class="glyphicon glyphicon-user"></span><b><?php echo htmlspecialchars($_SESSION["superAdminLoggedinUsername"]); ?></b></a></li>
      <li><a href="superAdminLogout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
  </div>
</nav>

<div class="container">
    <div class="jumbotron">
      <h1 align="center" style="color:black;">EEKI Super Admin Portal</h1>
    </div>
    <br>
    <div class="row">
        <h2 style="color:black;font-size:25px;"><span>Admin Configuration</span></h2>
        <!-- <label class="col-sm-4" style="color:white;font-size:25px;">Farm Configuration</label><hr> -->
    </div>
    <br>
    <br>
	<div class="row">
    <div class="col-md-2"></div>
        <div class="col-md-3">
            <a href="" class="btn btn-success btn-lg btn-block btn-huge" style="font-size:13pt;font-weight: bold;" data-toggle="modal" data-target="#modalLoginForm"><span class="glyphicon glyphicon-plus"></span> Add Admin</a>
        </div>
        <div class="col-md-3">
            <a href="#" class="btn btn-success btn-lg btn-block btn-huge" style="font-size:13pt;font-weight: bold;" data-toggle="modal" data-target="#modalLoginForm1"><span class="glyphicon glyphicon-pencil"></span> Update Admin</a>
        </div>
        <div class="col-md-3">
            <a href="#" class="btn btn-success btn-lg btn-block btn-huge" style="font-size:13pt;font-weight: bold;" data-toggle="modal" data-target="#modalLoginForm2"><span class="glyphicon glyphicon-trash"></span> Delete Admin</a>
        </div>
	</div>
  <br>
  <br>

  <div class="row">
    <h2 style="color:black;font-size:25px;"><span>Farm Login</span></h2>
      <!-- <label class="col-sm-4" style="color:white;font-size:25px;">User Configuration</label><hr> -->
  </div>
<br>
  <div class="row">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="form-group row">
        <div class="col-sm-3"></div>
        <label class="col-sm-2" style="color:white;font-size:25px;">Farm Name :</label>
        <div class="col-md-3">
          <select name="login_farm" id="login_farm" style=" height:48px;font-size:13pt;text-align-last:center;font-weight: bold;" class="form-control">
                 <option value="">--- Select Farm ---</option>


                 <?php

                     $farmData = mysqli_query($link,"SELECT ANY_VALUE(farmName) as farmName , ANY_VALUE(farmId) as farmId FROM farms GROUP BY farmId");
                     while($row2 = $farmData->fetch_assoc()){
                         echo "<option value='".$row2['farmId']."'>".$row2['farmName']."</option>";
                     }


                 ?>


          </select>

        </div>
         &nbsp;
          <input type="submit" class="btn btn-primary btn-lg" value="Login to Farm">
      </div>
    </form>


  </div>

    <br>
</div>
<script type="text/javascript">



// for user mail in updating
$( "select[id='edit_select_admin_username']" ).change(function () {
  var user = $(this).val();


  if(user) {


      $.ajax({
          url: "ajaxadminmail.php",
          dataType: 'Json',
          data: {'id':user},
          success: function(response) {
              $('#edit_admin_username').val(user);
              $('#edit_admin_mail').val(response.usermail);
          }
      });


  }
});
</script>
</body>
</html>

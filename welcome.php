<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

  if(isset($_POST['farm_ip']) && isset($_POST['farm_id']) && isset($_POST['farm_port']) && isset($_POST['farm_name']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['usermail']) && isset($_POST['submit_register']))
  {

              $response = array();
              $username = $_POST['username'];
              $usermail = $_POST['usermail'];
              $pass = $_POST['password'];
              $password = password_hash($pass, PASSWORD_DEFAULT); // Creates a password hash
              $farmip = $_POST['farm_ip'];
              $farmid = $_POST['farm_id'];
              $farmname = $_POST['farm_name'];
              $farmport = $_POST['farm_port'];

              $result1 = mysqli_query($link,"SELECT * FROM farms WHERE farmId ='$farmid'");

               if(mysqli_num_rows($result1) > 0)
               {

                             $response["success"] = 0;
                             $response["message"] = "Farm Already Registered";
                             echo '<script type="text/javascript">';
                             echo 'alert("Farm Already Registered");';
                             echo 'window.location.href = "welcome.php";';
                             echo '</script>';
                             // echo json_encode($response);

               }
               else
               {
                  $result2 = mysqli_query($link,"INSERT INTO farms(username,email,password,farmIp,farmPort,farmId,farmName) VALUES('$username','$usermail','$password','$farmip','$farmport','$farmid','$farmname')");
                        if ($result2)
                              {
                              $response["success"] = 1;
                              $response[$farmname] = "Successfully Registered";
                              require_once("mail_function_admin.php");
                              $mail_status = sendFarmNotif($usermail,$username,$pass);
                              echo '<script type="text/javascript">';
                              echo 'alert("Successfully Registered Farm");';
                              echo 'window.location.href = "welcome.php";';
                              echo '</script>';

                              // echo json_encode($response);

                              }
                        else
                              {
                              $response["success"] = 0;
                              $response["message"] = "Failed to register farm";
                              echo '<script type="text/javascript">';
                              echo 'alert("Failed to register farm");';
                              echo 'window.location.href = "welcome.php";';
                              echo '</script>';
                              // echo json_encode($response);
                              }


               }


  }

  if(isset($_POST['edit_farm_ip']) && isset($_POST['edit_farm_id']) && isset($_POST['edit_farm_port']) && isset($_POST['edit_farm_name']) && isset($_POST['submit_update']))
  {

              $response = array();
              $farmip = $_POST['edit_farm_ip'];
              $farmid = $_POST['edit_farm_id'];
              $farmname = $_POST['edit_farm_name'];
              $farmport = $_POST['edit_farm_port'];

               $result1 = mysqli_query($link,"SELECT * FROM farms WHERE farmId ='$farmid'");

               if(mysqli_num_rows($result1) > 0)
               {

                 $result3 = mysqli_query($link,"UPDATE farms SET farmName = '$farmname',farmPort = '$farmport' WHERE farmId = '$farmid'");
                       if ($result3)
                             {
                             $response["success"] = 1;
                             $response[$farmname] = "Successfully Updated";
                             echo '<script type="text/javascript">';
                             echo 'alert("Successfully Updated Farm");';
                             echo 'window.location.href = "welcome.php";';
                             echo '</script>';
                             // echo json_encode($response);

                             }
                       else
                             {
                             $response["success"] = 0;
                             $response["message"] = "Failed to update farm";
                             echo '<script type="text/javascript">';
                             echo 'alert("Failed to update farm");';
                             echo 'window.location.href = "welcome.php";';
                             echo '</script>';
                             // echo json_encode($response);
                             }


               }
               else
               {
                              $response["success"] = 0;
                              $response["message"] = "Farm Dosen't Exist";
                              echo '<script type="text/javascript">';
                              echo 'alert("Farm Does not Exist");';
                              echo 'window.location.href = "welcome.php";';
                              echo '</script>';

                              // echo json_encode($response);

               }


  }

  if(isset($_POST['delete_farm']))
  {
    $response = array();
    $farmid = $_POST['delete_farm'];

    $result1 = mysqli_query($link,"SELECT * FROM farms WHERE farmId ='$farmid'");

    if(mysqli_num_rows($result1) > 0)
    {

      $result2 = mysqli_query($link,"DELETE FROM farms WHERE farmId='$farmid'");
            if ($result2)
                  {
                  $response["success"] = 1;
                  $response["message"] = "Successfully Deleted";
                  echo '<script type="text/javascript">';
                  echo 'alert("Successfully Deleted");';
                  echo 'window.location.href = "welcome.php";';
                  echo '</script>';
                  // echo json_encode($response);

                  }
            else
                  {
                  $response["success"] = 0;
                  $response["message"] = "Failed to delete farm";
                  echo '<script type="text/javascript">';
                  echo 'alert("Failed to delete farm");';
                  echo 'window.location.href = "welcome.php";';
                  echo '</script>';
                  // echo json_encode($response);
                  }


    }
    else
    {
                   $response["success"] = 0;
                   $response["message"] = "Farm Dosen't Exist";
                   echo '<script type="text/javascript">';
                   echo 'alert("Farm Does not Exist");';
                   echo 'window.location.href = "welcome.php";';
                   echo '</script>';
                   // echo json_encode($response);

    }
  }


  if(isset($_POST['delete_farm_id']) && isset($_POST['delete_username']))
  {
    $response = array();
    $farmid = $_POST['delete_farm_id'];
    $username = $_POST['delete_username'];

    $result1 = mysqli_query($link,"SELECT * FROM farms WHERE farmId ='$farmid'");

    if(mysqli_num_rows($result1) > 0)
    {

      $result2 = mysqli_query($link,"DELETE FROM farms WHERE username='$username'");
            if ($result2)
                  {
                  $response["success"] = 1;
                  $response["message"] = "User ".$username." Successfully Deleted";
                  echo '<script type="text/javascript">';
                  echo 'alert("User '.$username.' Successfully Deleted");';
                  echo 'window.location.href = "welcome.php";';
                  echo '</script>';
                  // echo json_encode($response);

                  }
            else
                  {
                  $response["success"] = 0;
                  $response["message"] = "Failed to delete user";
                  echo '<script type="text/javascript">';
                  echo 'alert("Failed to delete user");';
                  echo 'window.location.href = "welcome.php";';
                  echo '</script>';
                  // echo json_encode($response);
                  }


    }
    else
    {
                   $response["success"] = 0;
                   $response["message"] = "user Dosen't Exist";
                   echo '<script type="text/javascript">';
                   echo 'alert("User Does not Exist");';
                   echo 'window.location.href = "welcome.php";';
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
      header("location: http://".$row['farmIp'].":".$row['farmPort']."/eekiAdminBoard?farm_id=".$row['farmId']."&farm_name=".$row['farmName']."&farm_user=".$_SESSION["username"]."&farm_userType=admin&sessionid=".rand(999999,10000000));


    }
    else
    {
                   $response["success"] = 0;
                   $response["message"] = "Farm Dosen't Exist";
                   echo '<script type="text/javascript">';
                   echo 'alert("Farm Does not Exist");';
                   echo 'window.location.href = "welcome.php";';
                   echo '</script>';
                   // echo json_encode($response);

    }
  }





  if(isset($_POST['add_farm_ip']) && isset($_POST['add_farm_id']) && isset($_POST['add_farm_port']) && isset($_POST['add_farm_name']) && isset($_POST['add_username']) && isset($_POST['add_password']) && isset($_POST['add_user_mail']) && isset($_POST['submit_add']))
  {

              $response = array();
              $username = $_POST['add_username'];
              $usermail = $_POST['add_user_mail'];
              $pass = $_POST['add_password'];
              $password = password_hash($pass, PASSWORD_DEFAULT); // Creates a password hash
              $farmip = $_POST['add_farm_ip'];
              $farmid = $_POST['add_farm_id'];
              $farmname = $_POST['add_farm_name'];
              $farmport = $_POST['add_farm_port'];

               $result1 = mysqli_query($link,"SELECT * FROM farms WHERE username ='$username'");

               if(mysqli_num_rows($result1) > 0)
               {

                             $response["success"] = 0;
                             $response["message"] = "User Already Registered";
                             echo '<script type="text/javascript">';
                             echo 'alert("User Already Registered");';
                             echo 'window.location.href = "welcome.php";';
                             echo '</script>';
                             // echo json_encode($response);

               }
               else
               {
                  $result2 = mysqli_query($link,"INSERT INTO farms(username,email,password,farmIp,farmPort,farmId,farmName) VALUES('$username','$usermail','$password','$farmip','$farmport','$farmid','$farmname')");
                        if ($result2)
                              {
                              $response["success"] = 1;
                              $response[$username] = "User ".$username." added Successfully";
                              require_once("mail_function_admin.php");
                              $mail_status = sendFarmNotif($usermail,$username,$pass);
                              echo '<script type="text/javascript">';
                              echo 'alert("User '.$username.' Successfully added");';
                              echo 'window.location.href = "welcome.php";';
                              echo '</script>';

                              // echo json_encode($response);

                              }
                        else
                              {
                              $response["success"] = 0;
                              $response["message"] = "Failed to add user";
                              echo '<script type="text/javascript">';
                              echo 'alert("Failed to add user");';
                              echo 'window.location.href = "welcome.php";';
                              echo '</script>';
                              // echo json_encode($response);
                              }


               }


  }





  if(isset($_POST['update_farm_ip']) && isset($_POST['update_farm_id']) && isset($_POST['update_select_username']) && isset($_POST['update_username']) && isset($_POST['update_password']) && isset($_POST['update_user_mail']) && isset($_POST['submit_update_user']))
  {

              $response = array();
              $oldusername = $_POST['update_select_username'];
              $newusername = $_POST['update_username'];
              $usermail = $_POST['update_user_mail'];
              $pass = $_POST['update_password'];
              $password = password_hash($pass, PASSWORD_DEFAULT); // Creates a password hash
              $farmip = $_POST['update_farm_ip'];
              $farmid = $_POST['update_farm_id'];

               $result1 = mysqli_query($link,"SELECT * FROM farms WHERE farmId ='$farmid'");

               if(mysqli_num_rows($result1) > 0)
               {

                $result2 = mysqli_query($link,"SELECT * FROM farms WHERE username ='$newusername'");
                if((mysqli_num_rows($result2) > 0) && ($newusername != $oldusername))
                {
                        $response["success"] = 0;
                        $response["message"] = "Username Already Registered";
                        echo '<script type="text/javascript">';
                        echo 'alert("Username Already Registered");';
                        echo 'window.location.href = "welcome.php";';
                        echo '</script>';
                        // echo json_encode($response);
                }
                else
                {
                  $result3 = mysqli_query($link,"UPDATE farms SET username = '$newusername', password = '$password', email = '$usermail' WHERE username = '$oldusername'");
                  if ($result3)
                        {
                        $response["success"] = 1;
                        $response[$farmname] = "Successfully Updated Farm User";
                        require_once("mail_function_admin.php");
                        $mail_status = sendFarmUpdateNotif($usermail,$newusername,$pass);
                        echo '<script type="text/javascript">';
                        echo 'alert("Successfully Updated Farm User");';
                        echo 'window.location.href = "welcome.php";';
                        echo '</script>';
                        // echo json_encode($response);

                        }
                  else
                        {
                        $response["success"] = 0;
                        $response["message"] = "Failed to update farm User";
                        echo '<script type="text/javascript">';
                        echo 'alert("Failed to update farm User");';
                        echo 'window.location.href = "welcome.php";';
                        echo '</script>';
                        // echo json_encode($response);
                        }
                }

                 


               }
               else
               {
                              $response["success"] = 0;
                              $response["message"] = "Farm Dosen't Exist";
                              echo '<script type="text/javascript">';
                              echo 'alert("Farm Does not Exist");';
                              echo 'window.location.href = "welcome.php";';
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
<title>Welcome to EEKI Portal</title>
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
        <h4 class="modal-title w-100 font-weight-bold" style="color:black;" >Register Farm</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="modalBody">
          <div class="form-group row">
            <div class="col-sm-2"></div>
            <label class="col-form-label col-sm-3" style="color:black;">Farm Id</label>
            <div class="col-sm-5">
              <select name="farm_id" id="farm_id" class="form-control" style="text-align-last:center;">
                     <option value="">--- Select Farm Id ---</option>


                     <?php

                         $mids = mysqli_query($link,"SELECT mid FROM publicip")or die(mysql_error());
                         while($row1 = $mids->fetch_assoc()){
                             echo "<option value='".$row1['mid']."'>".$row1['mid']."</option>";
                         }
                     ?>


              </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-2"></div>
              <label class="col-form-label col-sm-3" style="color:black;">Farm IP</label>
              <div class="col-sm-5">
                <input type="text" name="farm_ip" id="farm_ip" class="form-control" placeholder="Farm IP" required>
              </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-2"></div>
              <label class="col-form-label col-sm-3" style="color:black;">Port No.</label>
              <div class="col-sm-5">
                <input type="text" name="farm_port" id="farm_port" class="form-control" placeholder="Port No." required>
              </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-2"></div>
              <label class="col-form-label col-sm-3" style="color:black;">Farm Name</label>
              <div class="col-sm-5">
                <input type="text" name="farm_name" id="farm_name" class="form-control" placeholder="Farm Name" required>
              </div>
          </div>
            <div class="form-group row <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <div class="col-sm-2"></div>
                <label class="col-form-label col-sm-3" style="color:black;">Username</label>
                <div class="col-sm-5">
                    <input type="text" name="username"  class="form-control" value="<?php echo $username; ?>" placeholder="username" required>
                </div>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group row <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
              <div class="col-sm-2"></div>
                <label class="col-form-label col-sm-3" style="color:black;">Password</label>
                <div class="col-sm-5">
                  <input type="password" name="password" class="form-control" placeholder="password" required>
                </div>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group row <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <div class="col-sm-2"></div>
                <label class="col-form-label col-sm-3" style="color:black;">Email Id</label>
                <div class="col-sm-5">
                    <input type="text" name="usermail"  class="form-control" value="" placeholder="email-id" required>
                </div>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group row">
              <div class="col-sm-5"></div>
                <input type="submit" class="btn btn-primary" name="submit_register" value="Register Farm">
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
    <h4 class="modal-title w-100 font-weight-bold" style="color:black;" >Update Farm</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body mx-3">

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="modalBody">
      <div class="form-group row">
        <div class="col-sm-2"></div>
        <label class="col-form-label col-sm-3" style="color:black;">Select Farm</label>
        <div class="col-sm-5">
          <select name="edit_farm_id" id="edit_farm_id" class="form-control" style="text-align-last:center;" required>
                 <option value="">--- Select Farm ---</option>


                 <?php

                     $farmData = mysqli_query($link,"SELECT ANY_VALUE(farmName) as farmName , ANY_VALUE(farmId) as farmId FROM farms GROUP BY farmId");
                     while($row2 = $farmData->fetch_assoc()){
                         echo "<option value='".$row2['farmId']."'>".$row2['farmName']."</option>";
                     }
                 ?>


          </select>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-2"></div>
          <label class="col-form-label col-sm-3" style="color:black;">Farm IP</label>
          <div class="col-sm-5">
            <input type="text" name="edit_farm_ip" id="edit_farm_ip" class="form-control" placeholder="Farm IP" required readonly>
          </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-2"></div>
          <label class="col-form-label col-sm-3" style="color:black;">Port No.</label>
          <div class="col-sm-5">
            <input type="text" name="edit_farm_port" id="edit_farm_port" class="form-control" placeholder="Port No." required>
          </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-2"></div>
          <label class="col-form-label col-sm-3" style="color:black;">Edit Farm Name</label>
          <div class="col-sm-5">
            <input type="text" name="edit_farm_name" id="edit_farm_name" class="form-control" placeholder="Farm Name" required>
          </div>
      </div>
        <div class="form-group row">
          <div class="col-sm-5"></div>
            <input type="submit" class="btn btn-primary" name="submit_update" value="Update Farm">
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
    <h4 class="modal-title w-100 font-weight-bold" style="color:black;" >Delete a Farm</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body mx-3">

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="modalBody">
      <div class="form-group row">
        <div class="col-sm-2"></div>
        <label class="col-form-label col-sm-3" style="color:black;">Farm Name</label>
        <div class="col-sm-5">
          <select name="delete_farm" id="delete_farm" class="form-control" style="text-align-last:center;" required>
                 <option value="">--- Select Farm ---</option>


                 <?php

                     $farmData = mysqli_query($link,"SELECT ANY_VALUE(farmName) as farmName , ANY_VALUE(farmId) as farmId FROM farms GROUP BY farmId");
                     while($row2 = $farmData->fetch_assoc()){
                         echo "<option value='".$row2['farmId']."'>".$row2['farmName']."</option>";
                     }
                 ?>


          </select>
        </div>
      </div>

        <div class="form-group row">
          <div class="col-sm-5"></div>
            <input type="submit" class="btn btn-primary" value="Delete Farm">
        </div>
    </form>

  </div>

  <div class="modal-footer d-flex justify-content-center">

  </div>
</div>
</div>
</div>
<!-- end of modal for deleting farm -->





<div class="modal fade" id="modalLoginForm3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header text-center">
    <h4 class="modal-title w-100 font-weight-bold" style="color:black;" >Add a Farm User</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body mx-3">

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="modalBody">
      <div class="form-group row">
        <div class="col-sm-2"></div>
        <label class="col-form-label col-sm-3" style="color:black;">Farm Name</label>
        <div class="col-sm-5">
          <select name="add_farm_name" id="add_farm_name" class="form-control" style="text-align-last:center;" required>
                 <option value="">--- Select Farm---</option>


                 <?php

                     $mids = mysqli_query($link,"SELECT ANY_VALUE(farmName) as farmName FROM farms GROUP BY farmId");
                     while($row1 = $mids->fetch_assoc()){
                         echo "<option value='".$row1['farmName']."'>".$row1['farmName']."</option>";
                     }
                 ?>


          </select>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-2"></div>
          <label class="col-form-label col-sm-3" style="color:black;">Farm Id</label>
          <div class="col-sm-5">
            <input type="text" name="add_farm_id" id="add_farm_id" class="form-control" placeholder="Farm ID" readonly>
          </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-2"></div>
          <label class="col-form-label col-sm-3" style="color:black;">Farm IP</label>
          <div class="col-sm-5">
            <input type="text" name="add_farm_ip" id="add_farm_ip" class="form-control" placeholder="Farm IP" readonly>
          </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-2"></div>
          <label class="col-form-label col-sm-3" style="color:black;">Port No.</label>
          <div class="col-sm-5">
            <input type="text" name="add_farm_port" id="add_farm_port" class="form-control" placeholder="Port No." readonly>
          </div>
      </div>
        <div class="form-group row <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <div class="col-sm-2"></div>
            <label class="col-form-label col-sm-3" style="color:black;">Username</label>
            <div class="col-sm-5">
                <input type="text" name="add_username"  class="form-control" value="<?php echo $username; ?>" placeholder="username" required>
            </div>
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group row <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
          <div class="col-sm-2"></div>
            <label class="col-form-label col-sm-3" style="color:black;">Password</label>
            <div class="col-sm-5">
              <input type="password" name="add_password" class="form-control" placeholder="password" required>
            </div>
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group row">
            <div class="col-sm-2"></div>
            <label class="col-form-label col-sm-3" style="color:black;">Email Id</label>
            <div class="col-sm-5">
                <input type="text" name="add_user_mail"  class="form-control" value="" placeholder="Email Id" required>
            </div>
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group row">
          <div class="col-sm-5"></div>
            <input type="submit" class="btn btn-primary" name="submit_add" value="Add User">
        </div>
    </form>

  </div>

  <div class="modal-footer d-flex justify-content-center">

  </div>
</div>
</div>
</div>

<!-- end of modal for addinf farm user -->


<div class="modal fade" id="modalLoginForm4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header text-center">
    <h4 class="modal-title w-100 font-weight-bold" style="color:black;" >Delete Farm User</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body mx-3">

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="modalBody">
      <div class="form-group row">
        <div class="col-sm-2"></div>
        <label class="col-form-label col-sm-3" style="color:black;">Select Farm</label>
        <div class="col-sm-5">
          <select name="delete_farm_id" id="delete_farm_id" class="form-control" style="text-align-last:center;" required>
                 <option value="">--- Select Farm ---</option>


                 <?php

                     $farmData = mysqli_query($link,"SELECT ANY_VALUE(farmName) as farmName , ANY_VALUE(farmId) as farmId FROM farms GROUP BY farmId");
                     while($row2 = $farmData->fetch_assoc()){
                         echo "<option value='".$row2['farmId']."'>".$row2['farmName']."</option>";
                     }
                 ?>


          </select>
        </div>
      </div>
      <div class="form-group row <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
          <div class="col-sm-2"></div>
          <label class="col-form-label col-sm-3" style="color:black;">Select User</label>
          <div class="col-sm-5">
              <select name="delete_username" id="delete_username" class="form-control" style="text-align-last:center;" required>
                     <option value="">--- Select user ---</option>


              </select>
          </div>
      </div>
        <div class="form-group row">
          <div class="col-sm-5"></div>
            <input type="submit" class="btn btn-primary" value="Delete Farm User">
        </div>
    </form>

  </div>

  <div class="modal-footer d-flex justify-content-center">

  </div>
</div>
</div>
</div>

<!-- end of modal for adding farm user -->

<div class="modal fade" id="modalLoginForm5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header text-center">
    <h4 class="modal-title w-100 font-weight-bold" style="color:black;" >Update Farm User</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body mx-3">

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="modalBody">
      <div class="form-group row">
        <div class="col-sm-2"></div>
        <label class="col-form-label col-sm-3" style="color:black;">Select Farm</label>
        <div class="col-sm-5">
          <select name="update_farm_id" id="update_farm_id" class="form-control" style="text-align-last:center;" required>
                 <option value="">--- Select Farm ---</option>


                 <?php

                     $farmData = mysqli_query($link,"SELECT ANY_VALUE(farmName) as farmName , ANY_VALUE(farmId) as farmId FROM farms GROUP BY farmId");
                     while($row2 = $farmData->fetch_assoc()){
                         echo "<option value='".$row2['farmId']."'>".$row2['farmName']."</option>";
                     }
                 ?>


          </select>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-2"></div>
          <label class="col-form-label col-sm-3" style="color:black;">Farm IP</label>
          <div class="col-sm-5">
            <input type="text" name="update_farm_ip" id="update_farm_ip" class="form-control" placeholder="Farm IP" required readonly>
          </div>
      </div>
      <div class="form-group row">
          <div class="col-sm-2"></div>
          <label class="col-form-label col-sm-3" style="color:black;">Select User</label>
          <div class="col-sm-5">
              <select name="update_select_username" id="update_select_username" class="form-control" style="text-align-last:center;" required>
                     <option value="">--- Select user ---</option>


              </select>
          </div>
      </div>
      <div class="form-group row <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
          <div class="col-sm-2"></div>
          <label class="col-form-label col-sm-3" style="color:black;">New Username</label>
          <div class="col-sm-5">
          <input type="text" name="update_username" id="update_username" class="form-control" placeholder="New username" required>
          </div>
      </div>
      <div class="form-group row <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
          <div class="col-sm-2"></div>
            <label class="col-form-label col-sm-3" style="color:black;">New Password</label>
            <div class="col-sm-5">
              <input type="password" name="update_password" id="update_password" class="form-control" placeholder="New password" required>
            </div>
            <span class="help-block"><?php echo $password_err; ?></span>
      </div>
      <div class="form-group row">
        <div class="col-sm-2"></div>
          <label class="col-form-label col-sm-3" style="color:black;">Edit Email Id</label>
          <div class="col-sm-5">
            <input type="text" name="update_user_mail" id="update_user_mail" class="form-control" placeholder="Email Id" required>
          </div>
      </div>
        <div class="form-group row">
          <div class="col-sm-5"></div>
            <input type="submit" class="btn btn-primary" name="submit_update_user" value="Update Farm User">
        </div>
    </form>

  </div>

  <div class="modal-footer d-flex justify-content-center">

  </div>
</div>
</div>
</div>
<!-- end of modal for updating farm -->






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
      <li class="active"><a href="#"><span class="glyphicon glyphicon-user"></span><b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
  </div>
</nav>

<div class="container">
    <div class="jumbotron">
      <h1 align="center" style="color:black;">Welcome to EEKI Portal</h1>
    </div>
    <br>
    <div class="row">
        <h2 style="color:black;font-size:25px;"><span>Farm Configuration</span></h2>
        <!-- <label class="col-sm-4" style="color:white;font-size:25px;">Farm Configuration</label><hr> -->
    </div>
    <br>
    <br>
	<div class="row">
    <div class="col-md-2"></div>
        <div class="col-md-3">
            <a href="" class="btn btn-success btn-lg btn-block btn-huge" style="font-size:13pt;font-weight: bold;" data-toggle="modal" data-target="#modalLoginForm"><span class="glyphicon glyphicon-plus"></span> Register Farm</a>
        </div>
        <div class="col-md-3">
            <a href="#" class="btn btn-success btn-lg btn-block btn-huge" style="font-size:13pt;font-weight: bold;" data-toggle="modal" data-target="#modalLoginForm1"><span class="glyphicon glyphicon-pencil"></span> Update Farm </a>
        </div>
        <div class="col-md-3">
            <a href="#" class="btn btn-success btn-lg btn-block btn-huge" style="font-size:13pt;font-weight: bold;" data-toggle="modal" data-target="#modalLoginForm2"><span class="glyphicon glyphicon-trash"></span> Delete Farm</a>
        </div>
	</div>
  <br>
  <br>
  <div class="row">
    <h2 style="color:black;font-size:25px;"><span>User Configuration</span></h2>
      <!-- <label class="col-sm-4" style="color:white;font-size:25px;">User Configuration</label><hr> -->
  </div>
  <br>
  <br>

  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-3">
        <a href="" class="btn btn-success btn-lg btn-block btn-huge" style="font-size:13pt;font-weight: bold;" data-toggle="modal" data-target="#modalLoginForm3"><span class="glyphicon glyphicon-plus"></span> Add Farm User</a>
    </div>
    <div class="col-md-3">
        <a href="" class="btn btn-success btn-lg btn-block btn-huge" style="font-size:13pt;font-weight: bold;" data-toggle="modal" data-target="#modalLoginForm5"><span class="glyphicon glyphicon-pencil"></span> Update Farm User</a>
    </div>
    <div class="col-md-3">
        <a href="" class="btn btn-success btn-lg btn-block btn-huge" style="font-size:13pt;font-weight: bold;" data-toggle="modal" data-target="#modalLoginForm4"><span class="glyphicon glyphicon-trash"></span> Delete Farm User</a>
    </div>
  </div>
<br>
<br>
  <!-- <hr> -->
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
// for Adding a farm
$( "select[id='farm_id']" ).change(function () {
  var farmID = $(this).val();


  if(farmID) {


      $.ajax({
          url: "ajaxip.php",
          dataType: 'Json',
          data: {'id':farmID},
          success: function(response) {
              $('#farm_ip').val(response.farmip);
              $('#farm_port').val(response.port);
          }
      });


  }
});


// for updating farm
$( "select[id='edit_farm_id']" ).change(function () {
  var editFarmID = $(this).val();

  if(editFarmID) {


      $.ajax({
          url: "ajaxuser.php",
          dataType: 'Json',
          data: {'id':editFarmID},
          success: function(response) {
            $('#edit_farm_ip').val(response[0].farmIp);
            $('#edit_farm_name').val(response[0].farmName);
            $('#edit_farm_port').val(response[0].farmPort);


          }
      });


  }
});


// for updating farm user
$( "select[id='update_farm_id']" ).change(function () {
  var updateFarmID = $(this).val();

  $('#update_select_username').empty();
  if(updateFarmID) {


      $.ajax({
          url: "ajaxuser.php",
          dataType: 'Json',
          data: {'id':updateFarmID},
          success: function(response) {
            $('#update_farm_ip').val(response[0].farmIp);
            $('#update_select_username').append("<option value=''>--- Select user ---</option>");
            $.each(response, function(index) {
            $('#update_select_username').append("<option value='"+response[index].username+"'>"+response[index].username+"</option>");
            
        });

          }
      });


  }
});


// for adding user to  farm
$( "select[id='add_farm_name']" ).change(function () {
  var addFarmName = $(this).val();


  if(addFarmName) {


      $.ajax({
          url: "ajaxadd.php",
          dataType: 'Json',
          data: {'id':addFarmName},
          success: function(response) {
              $('#add_farm_ip').val(response.farmip);
              $('#add_farm_id').val(response.farmid);
              $('#add_farm_port').val(response.farmport);
          }
      });


  }
});


// for deleting farm users
$( "select[id='delete_farm_id']" ).change(function () {
  var deleteFarmID = $(this).val();

  $('#delete_username').empty();
  if(deleteFarmID) {


      $.ajax({
          url: "ajaxuser.php",
          dataType: 'Json',
          data: {'id':deleteFarmID},
          success: function(response) {
            $.each(response, function(index) {
            $('#delete_username').append("<option value='"+response[index].username+"'>"+response[index].username+"</option>");

        });

          }
      });


  }
});


// for user mail in updating
$( "select[id='update_select_username']" ).change(function () {
  var user = $(this).val();


  if(user) {


      $.ajax({
          url: "ajaxmail.php",
          dataType: 'Json',
          data: {'id':user},
          success: function(response) {
              $('#update_user_mail').val(response.usermail);
              $('#update_username').val(user);
          }
      });


  }
});
</script>
</body>
</html>

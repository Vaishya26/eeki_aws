<?php
require('config.php');
   
if(isset($_POST['farmName']) && isset($_POST['username']) && isset($_POST['password']))
  {

              $response = array();
              $username = $_POST['username'];
              $pass = $_POST['password'];
              $password = password_hash($pass, PASSWORD_DEFAULT); // Creates a password hash
              $farmname = $_POST['farmName'];

              $result1 = mysqli_query($link,"SELECT * FROM users WHERE username ='$username' AND password = '$password'");

               if(mysqli_num_rows($result1) > 0)
               {
                    $farmData = mysqli_query($link,"SELECT ANY_VALUE(farmIp) as farmIp, ANY_VALUE(farmPort) as farmPort FROM farms WHERE farmName ='$farmname' GROUP BY farmId")or die(mysql_error());
                    $row = mysqli_fetch_assoc($farmData);
                    $json = [];
                    $json["Auth"] = true;
                    $json['farmIp'] = $row['farmIp'];
                    $json['farmPort'] = $row['farmPort'];
                    echo json_encode($json);

                             
               }
               else
               {
                    $json =[];  
                    $json["Auth"] = false;
                    $json["message"] = "Incorrect Authentication Deatils";
                    echo json_encode($json);

               }


  }
  else
  {
    $json =[];  
    $json["Auth"] = false;
    $json["message"] = "Missing Parameters";
    echo json_encode($json);
  }

  mysqli_close($link);
?>
<?php
require('config.php');
   
if(isset($_POST['username']) && isset($_POST['password']))
  {

              $response = array();
              $username = $_POST['username'];
              $password = $_POST['password'];
            //   $password = password_hash($pass, PASSWORD_DEFAULT); // Creates a password hash
              $farmname = $_POST['farmName'];

              $result1 = mysqli_query($link,"SELECT * FROM users WHERE username ='$username'");

               if(mysqli_num_rows($result1) > 0)
               {
                    $r = mysqli_fetch_assoc($result1);
                    $hashed_password = $r['password'];
                    if(password_verify($password, $hashed_password))
                    {
                        $farmData = mysqli_query($link,"SELECT ANY_VALUE(farmName) as farmName , ANY_VALUE(farmId) as farmId FROM farms GROUP BY farmId");
                        $data = array();
                        while($row2 = $farmData->fetch_assoc()){
                            array_push($data,$row2['farmName']);
                     }

                        $json =[];  
                        $json["Auth"] = true;
                        $json["Farms"] = $data;
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
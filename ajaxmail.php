<?php


   require('config.php');
   $user = $_GET['id'];
   $usermail = mysqli_query($link,"SELECT email FROM farms WHERE username ='$user'")or die(mysql_error());
   $row = mysqli_fetch_assoc($usermail);
   $json = [];
   $json['usermail'] = $row['email'];
   echo json_encode($json);
   mysqli_close($link);
?>

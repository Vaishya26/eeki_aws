<?php


   require('config.php');
   $farmid = $_GET['id'];
   $farmData = mysqli_query($link,"SELECT username,farmIp,farmName,farmPort FROM farms WHERE farmId ='$farmid'")or die(mysql_error());
   $data = array();
   while($row = mysqli_fetch_assoc($farmData)){
        array_push($data,$row);
      }
   // $row = mysqli_fetch_all($farmData);
   echo json_encode($data);


   mysqli_close($link);
?>

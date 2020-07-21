<?php


   require('config.php');
   $farmname = $_GET['id'];
   $farmData = mysqli_query($link,"SELECT ANY_VALUE(farmIp) as farmIp, ANY_VALUE(farmId) as farmId, ANY_VALUE(farmPort) as farmPort FROM farms WHERE farmName ='$farmname' GROUP BY farmId")or die(mysql_error());
   $row = mysqli_fetch_assoc($farmData);
   $json = [];
   $json['farmip'] = $row['farmIp'];
   $json['farmid'] = $row['farmId'];
   $json['farmport'] = $row['farmPort'];
   echo json_encode($json);
   mysqli_close($link);
?>

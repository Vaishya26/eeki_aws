<?php


   require('config.php');
   $farmid = $_GET['id'];
   $farmip = mysqli_query($link,"SELECT * FROM publicip WHERE mid ='$farmid'")or die(mysql_error());
   $row = mysqli_fetch_assoc($farmip);
   $json = [];
   $json['farmip'] = $row['pip'];
   $json['port'] = $row['port'];
   echo json_encode($json);
   mysqli_close($link);
?>

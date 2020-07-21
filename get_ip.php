<?php
   header("Access-Control-Allow-Origin: *");
   header("Content-Type: application/json; charset=UTF-8");
   $dbhost = 'localhost';
   $dbuser = 'root';
   $dbpass = 'eeki';
   $dbname = 'eeki';
   $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
   //Creating Array for JSON response

   if(! $conn )
   {
     die('Could not connect to instance: ' . mysqli_error($conn));
   }
   else{
   echo 'Connected to server Successfully!';

   if ( isset($_GET['masterid']) && isset($_GET['publicip']) ) {
        $response = array();

       $data1 = $_GET['masterid'];
       $data2 = $_GET['publicip'];
       $data3 = $_GET['port'];

       $result1 = mysqli_query($conn,"SELECT * FROM publicip WHERE mid ='$data1'");

       // Fire SQL query to insert product into database
       if(mysqli_num_rows($result1) > 0)
       {
           $result2 = mysqli_query($conn,"UPDATE publicip SET pip = '$data2' WHERE mid = '$data1'");
           $farmUpdate = mysqli_query($conn,"UPDATE farms SET farmIp = '$data2' WHERE farmId = '$data1'");
              if ($result2)
                    {
                      // successfully updated data in database
                       $response["success"] = 1;
                       $response[$data2] = "Updated";
                       echo json_encode($response);

                     }
              else
                    {
                     // Failed to update data in database
                     $response["success"] = 0;
                     $response["message"] = "Failed to update data";
                     echo json_encode($response);
                    }
       }
       else
       {
          $result3 = mysqli_query($conn,"INSERT INTO publicip(mid,pip,port) VALUES('$data1','$data2','$data3')");
                if ($result3)
                      {
                      $response["success"] = 1;
                      $response[$data1] = "inserted";
                      echo json_encode($response);

                      }
                else
                      {
                      $response["success"] = 0;
                      $response["message"] = "Failed to insert data";
                      echo json_encode($response);
                      }

       }





  }
  else{
    // If required parameter is missing
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";

    // Show JSON response
    echo json_encode($response);
 //    $output = mysqli_query($conn,"SELECT id,Data,reg_date FROM harshit");
 //    while($row = mysqli_fetch_assoc($output)) {
 // echo "id: " . $row["id"]. " - Data: " . $row["Data"]. " " . $row["reg_date"]."<br>";
 //  }
}
}




   mysql_close($conn);
?>

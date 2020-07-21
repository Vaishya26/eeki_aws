<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin_farm"]) || $_SESSION["loggedin_farm"] !== true){
    header("location: welcome.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>EEKIBoard</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style type="text/css">
	.btn-huge{
    padding-top:20px;
    padding-bottom:20px;
    width: 100%;
    height: 100%;
}
body {
		color: #fff;
		background: #4c535d;
		font-family: 'Roboto', sans-serif;
	}


</style>
</head>
<body>













<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">EEKI Automation</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="welcome.php">Home</a></li>
      <!--<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>-->
      <!--  <ul class="dropdown-menu">-->
      <!--    <li><a href="#">Page 1-1</a></li>-->
      <!--    <li><a href="#">Page 1-2</a></li>-->
      <!--    <li><a href="#">Page 1-3</a></li>-->
      <!--  </ul>-->
      <!--</li>-->
      <li class="active"><a href="#">EEKI Board</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="#"><span class="glyphicon glyphicon-user"></span><b><?php echo htmlspecialchars($_SESSION["username_farm"]); ?></b></a></li>
      <li><a href="#"><span class="glyphicon glyphicon-user"></span><b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>

<div class="container">
    <div class="jumbotron">
    <!--<h1 align="center" style="color:black;">Welcome to {{payload.farm_id}}</h1>      -->
    <h1 align="center" style="color:black;">Welcome to Farm1</h1>

  </div>
    <br>

	<div class="row">
        <div class="col-md-6">
            <a href="http://223.226.111.107:1880/configure" class="btn btn-success btn-lg btn-block btn-huge" data-toggle="modal" data-target="">Configure</a>
        </div>
        <div class="col-md-6">
            <a href="http://223.226.111.107:1880/ui" class="btn btn-info btn-lg btn-block btn-huge" data-toggle="modal" data-target="">Monitor</a>
        </div>

	</div>
    <hr>


    <br>
</div>
</body>
</html>

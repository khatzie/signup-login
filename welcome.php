<?php
	session_start();
	
	if($_SESSION["loggedin"] != true && empty($_SESSION["id"])){
		header("location: login.php");
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
	<style>
		.container{
			padding: 50px;
		}
		
		.container .name{
			text-transform: capitalize;
			font-size:20px;
		}
		
		.container .uname{
			text-transform: lowercase;
			font-size:14px;
			font-weight:italic;
		}
	</style>
</head>
<body>
	<div class="container">
		WELCOME! <span class="name"><?php echo $_SESSION['fname']." ".$_SESSION['lname']; ?> </span> (<span class='uname'><?php echo $_SESSION['uname']; ?> </span>)
		
		<a href="logout.php">Log Out</a>
	</div>
</body>
</html>
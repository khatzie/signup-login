<?php
	include 'config.php';
	session_start();
	$uname 		= isset($_POST['username'])? trim($_POST['username']) : "";
	$pword 		= isset($_POST['password'])? trim($_POST['password']) : "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$query = "SELECT user_id, firstname, lastname, password FROM tbl_users WHERE username = ?";
		if($stmt = mysqli_prepare($db, $query)){
		     mysqli_stmt_bind_param($stmt, "s", $uname); // Bind Variable this will help you avoid SQL injections , s for string
			 if(mysqli_stmt_execute($stmt)){
				 $result = mysqli_stmt_store_result($stmt);
				 if(mysqli_stmt_num_rows($stmt) == 1){
					mysqli_stmt_bind_result($stmt, $id, $fname, $lname, $hashed_password);
					if(mysqli_stmt_fetch($stmt)){
						if(password_verify($pword, $hashed_password)){
							$_SESSION["loggedin"] = true;
							$_SESSION["id"] = $id;
							$_SESSION["uname"] = $uname; 
							$_SESSION["fname"] = $fname;
							$_SESSION["lname"] = $lname;  
							header("location: welcome.php");
						}else{
			 	 			$msg = "Invalid password!";
			 	 			$class = "alert-danger";
						}
					}
				 }else{
	 	 			$msg = "Account does not exist.";
	 	 			$class = "alert-danger";
				 }
			 }
			 else{
	 			$msg = "Oops! Something went wrong. Please try again later.";
	 			$class = "alert-danger";
			 }

			 mysqli_stmt_close($stmt);
		}
	
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
		
		.container form{
			max-width: 400px;
			margin:0 auto;
		}
		.container p{
			padding-top:10px;
		}
	</style>
</head>
<body>
	<div class="container">
		<form action="" method="post">
	      <legend>Log In</legend>
		  <div class="alert <?php echo $class; ?> alert-dismissible fade show" role="alert" <?php echo (empty($msg)) ? "style='display:none;'" : ""; ?>>
		     <?php echo $msg ; ?>
		    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		  </div>
		  <div class="mb-3">
		    <label for="UsernameInput" class="form-label">Username</label>
		    <input type="text" class="form-control" name="username" id="username" value="<?php echo $uname; ?>">
		  </div>
		  <div class="mb-3">
		    <label for="PasswordInput" class="form-label">Password</label>
		    <input type="password" class="form-control" name="password" id="password" value="<?php echo $pword; ?>">
		  </div>
		  
		  <button type="submit" class="btn btn-primary">Log In</button>
		  
		   <p>Don't have an account? <a href="signup.php">Sign Up Now </a></p>
		</form>
	</div>
</body>
</html>
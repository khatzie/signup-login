<?php
	include 'config.php';
	
	$fname 		= isset($_POST['firstname'])? trim($_POST['firstname']) : ""; //trim remove whitespaces, isset check if variable is empty
	$lname 		= isset($_POST['lastname'])? trim($_POST['lastname']) : "";
	$uname 		= isset($_POST['username'])? trim($_POST['username']) : "";
	$pword 		= isset($_POST['password'])? trim($_POST['password']) : "";
	$cpword 	= isset($_POST['confirmpassword'])? trim($_POST['confirmpassword']) : "";
	$error 		= false; //declare error as false initially the form does not have error
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		
		if(count(array_filter($_POST)) == count($_POST)){ //array_filter remove empty fields in array, $_POST return array value, compare by counting if all $_POST fields has value
			if(strlen($pword) >= 6){
				if($pword != $cpword){
		 			$msg = "Password did not match!";
		 			$class = "alert-danger";
					$error = true;
				}
			}else{
	 			$msg = "Password must have atleast 6 characters.";
	 			$class = "alert-danger";
				$error = true;
			}
			
			if($error === false){
				$query = "SELECT user_id FROM tbl_users WHERE username = ?";
				if($stmt = mysqli_prepare($db, $query)){
				     mysqli_stmt_bind_param($stmt, "s", $uname); // Bind Variable this will help you avoid SQL injections , s for string
					 if(mysqli_stmt_execute($stmt)){
						 mysqli_stmt_store_result($stmt);
	 					 if(mysqli_stmt_num_rows($stmt) == 1){
	 	 		 			$msg = "Username is already taken.";
	 	 		 			$class = "alert-danger";
							$error = true;
	 					 }
	 				 }
	 				 else{
	 		 			$msg = "Oops! Something went wrong. Please try again later.";
	 		 			$class = "alert-danger";
	 				 }

	 				 mysqli_stmt_close($stmt);
				}
			
			}
			
			if($error === false){
			 	$query = "INSERT INTO tbl_users (firstname, lastname, username, password) VALUES (?, ?, ?, ?)";
	 			if($stmt = mysqli_prepare($db, $query)){	
	 			     mysqli_stmt_bind_param($stmt, "ssss", $fname, $lname, $uname, password_hash($pword, PASSWORD_DEFAULT)); //password_hash encrypt password
					 
					 if(mysqli_stmt_execute($stmt)){
						 header("location: login.php");
					 }else{
	  		 			$msg = "Oops! Something went wrong. Please try again later.";
	  		 			$class = "alert-danger";
					 }
					 mysqli_stmt_close($stmt);
				 }
			}
			
			
		}else{
			$msg = "All fields are required!";
			$class = "alert-danger";
		}
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
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
		  <legend>Sign Up</legend>
		  <div class="alert <?php echo $class; ?> alert-dismissible fade show" role="alert" <?php echo (empty($msg)) ? "style='display:none;'" : ""; ?>>
		     <?php echo $msg ; ?>
		    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		  </div>
		  <div class="mb-3">
		    <label for="FirstnameInput" class="form-label">First Name</label>
		    <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $fname; ?>">
		  </div>
		  <div class="mb-3">
		    <label for="LastnameInput" class="form-label">Last Name</label>
		    <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo $lname; ?>">
		  </div>
		  <div class="mb-3">
		    <label for="UsernameInput" class="form-label">Username</label>
		    <input type="text" class="form-control" name="username" id="username" value="<?php echo $uname; ?>">
		  </div>
		  <div class="mb-3">
		    <label for="PasswordInput" class="form-label">Password</label>
		    <input type="password" class="form-control" name="password" id="password" value="<?php echo $pword; ?>">
		  </div>
		  <div class="mb-3">
		    <label for="ConfirmPasswordInput" class="form-label">Confirm Password</label>
		    <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" value="<?php echo $cpword; ?>">
		  </div>
		  
		  <button type="submit" class="btn btn-primary">Sign Up</button>
		  
		  <p>Already have an account? <a href="login.php">Login here </a></p>
		</form>
	</div>
</body>
</html>
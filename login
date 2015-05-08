<?php
	$error = "";
	include 'dboperation.php';
	if( isset( $_POST['login'] ) ){
		$email = mysql_real_escape_string( $_POST['email'] );
		$password = sha1( $_POST['password'] );
		$userarray = selectMember($email);
		$rs = $userarray['userinfo'];
		if($rs->num_rows == 0){
			$userarray = selectEmployer($email);
			$rs = $userarray['userinfo'];
		}
		$usertype = $userarray['usertype'];			
		$userinfo = mysqli_fetch_assoc($rs);
		if( is_null( $userinfo ) || $userinfo['Password'] != $password )
			$error = "The email or password is invalid<br>";
		else {
			$cookie_name = "usertype";
			$cookie_val = $usertype;
			setcookie($cookie_name, $cookie_val, time() + 3600, "/"); // 3600 = 1 hour
			$cookie_name = "userid";
			if($usertype == "seeker")
				$cookie_val = $userinfo['JobSeekerId'];
			else 
				$cookie_val = $userinfo['EmployerId'];
			setcookie($cookie_name, $cookie_val, time() + 3600, "/"); // 3600 = 1 hour
			header("Refresh: 0; homepage.php");
		}
	}

?>

<!DOCTYPE html>

	<html lang="en">
	
	<head>
	     <meta charset="utf-8" >
	     <title>Log in to Job Seeker</title>
	     <link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		
	
		<h1>Log In</h1>
			
		<form method="post" onsubmit="return validateLogInForm()" >
	
			
			<fieldset>
		   	<legend><b>Enter your details</b></legend>
				
				<input type="hidden" name="op" value="insert">			
				
				<div style="float:left; overflow:hidden; ">
					<p id="error"><?php echo $error ?></p>
					Email: <input type="text" id="email" name="email" ><br>
					Password: <input type="password" id="password" name="password" ><br>
					<input type="submit" id="login" name="login" value="Log In"><br><br>
					
					<a href="homepage.php" >Take me back to the home page</a>												
					
				</div>
	
			</fieldset>	
			
		</form>
			
		<script>
			function validateLogInForm() {
			    var email, password, cont = true, re = /.+@.+\..+/;
			    
			    email = document.getElementById("email").value;
			    password = document.getElementById("password").value;
				 var OK = re.exec( email );	
			
			    if ( email.length == 0 || !OK || password.length == 0 ) {
			    	document.getElementById( "error" ).innerHTML = "The email or password is invalid<br>";
			    	cont = false;
			    }
			
				 return cont;
					
			}
		</script>	
		
	</body>
	
</html>

				



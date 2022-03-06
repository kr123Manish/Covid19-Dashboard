<?php 
	$error = "";
	$serverName = ""; // update me
    	$connectionOptions = array(
        "Database" => "maindatabase", // update me
        "Uid" => "", // update me
        "PWD" => "" // update me
    	);
	    //Establishes the connection
	$conn = sqlsrv_connect($serverName, $connectionOptions);
	if($conn==false){
	    die(print_r(sqlsrv_errors(), true));
	}else{
		$email="";
		$password="";
		if (array_key_exists("login", $_POST)){
			// else echo "Connection Success"."<br>";
		    $email=$_REQUEST['login_name'];
	        $password=$_REQUEST['login_password'];
		    $sql="SELECT * FROM admin WHERE email_id='$email'";
		    $results=sqlsrv_query($conn,$sql);
		    $details = sqlsrv_fetch_array($results,SQLSRV_FETCH_ASSOC);
		    
		    if($details==null){
		    	$error = "User Not Found";
		    }else{
		    	session_start();
		    	$_SESSION['service_no']=$details['service_no'];
		    	// echo $_SESSION['service_no'];
		    	if($details['password']==$password){
		    		// echo "Ready for work";
		    		session_start();
		    		$_SESSION['auth']='true';
		    		header("Location: chat_app.php");
		    	}else{
		    		$error = "Incorrect Password";
		    	}
		    }
		   
		}

		
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin-login</title>
	<link rel="stylesheet" href="Admin-style.css?v=<?php echo time(); ?>">
	<!-- <link rel="stylesheet" type="text/css" href="Admin-style.css"> -->
	<!-- for font -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai+Looped:wght@500&display=swap" rel="stylesheet">
	<!--  -->
</head>
<body>
	<div class="container">
		
		<h1>Welcome to Admin Page</h1>
		
		<form id="form-1" method="post">
			<div class="error">
				<?php 
						if($error=="Incorrect Password"){
							echo "$error"."<br><a href='admin-resetp.php'>Click here to reset password</a>";
						}else{
							echo "$error";
						}
				
				?>

			</div>
			<div class="combo">
				<fieldset>
  					<legend>Email*</legend> 
						<input type="email" name="login_name" placeholder=" email" required value="<?php echo "$email";?>">
				</fieldset>
			</div>
			<div class="combo">
				
				<fieldset>
  					<legend>Password*</legend> 

						<input type="Password" name="login_password" placeholder="password" required id="pass" value="<?php echo "$password";?>">
						<img src="1.svg" class="eye" onclick="myFunction()">
				</fieldset>
			</div>
			<div class="combo-1">
				<button name="login">Login</button>
			</div>
				
		</form>

		
		<a href="index.php">Back to home</a>
	</div>
	<!-- ========javascript========== -->
	<script type="text/javascript">
		function myFunction() {
			// alert("Ready");
		  var x = document.getElementById("pass");
		  if (x.type === "password") {
		    x.type = "text";
		  } else {
		    x.type = "password";
		  }
		}
	</script>
</body>
</html>

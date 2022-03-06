<?php 
	$error = "";
	$service_no="";
	$new_paswword="";
	$confirm_paswword="";
	session_start();
	// echo $_SESSION['service_no'];

if(isset($_SESSION['service_no'])){
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
		 // echo "Connection Success"."<br>";
		if (array_key_exists("update_password", $_POST)){
			
			$service_no=$_REQUEST['service_no'];
			$new_paswword=$_REQUEST['new_password'];
			$confirm_paswword=$_REQUEST['confirm_password'];
			// print_r("$service_no"."=>"."$new_paswword"."=>"."$confirm_paswword");
			if ($service_no==$_SESSION['service_no']) {
				
				if($new_paswword!=$confirm_paswword){
					$error="Password did not match";
				}else{
					// echo "Ready to update";
					$sql="UPDATE admin SET password='$new_paswword' WHERE service_no='$service_no'";
		    		$results=sqlsrv_query($conn,$sql);
		    		if ($results) {
		    			echo '<script>alert("Password Changed Succesfully");
		    				window.location.href = "admin.php";</script>';
		    			session_unset();
		    			session_destroy();
		    			exit();	
		    		}else{
		    			$error="Facing Some error please try Again later";
		    		}
				}

			}else{
				$error="Incorrect Sevice No";
				
			}
		}
		   
		}

}else{
		header("Location: index.php");
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
		<form id="form-2" method="post">
			<div class="error">
				<?php echo "$error";?>
			</div>
			<div class="combo">
				
				<fieldset>
  					<legend>Service no*</legend> 
						<input type="text" name="service_no" placeholder="*service-no" required value="<?php echo $service_no ?>">
				</fieldset>
			</div>
			<div class="combo">
				
				<fieldset>
  					<legend>New Password*</legend> 
						<input type="Password" name="new_password" placeholder="*password" required value="<?php echo $new_paswword ?>" id="pass">
						<img src="1.svg" class="eye" onclick="myFunction('pass')">
				</fieldset>
			</div>
			<div class="combo">
				
				<fieldset>
  					<legend>Confirm Password*</legend> 
						<input type="Password" name="confirm_password" placeholder="*confirm-password" required value="<?php echo $confirm_paswword ?>" id="cpass">
						<img src="1.svg" class="eye" onclick="myFunction('cpass')">
				</fieldset>
			</div>
			<div class="combo-1">
				<button name="update_password">Update</button>
			</div>
				
		</form>
		<a href="index.php">Back to home</a>
	</div>
	<!-- ==================javascript============= -->
	<script type="text/javascript">
		function myFunction(clicked_id) {
			// alert(clicked_id);
		  var x = document.getElementById(clicked_id);
		  if (x.type === "password") {
		    x.type = "text";
		  } else {
		    x.type = "password";
		  }
		}
	</script>
</body>
</html>

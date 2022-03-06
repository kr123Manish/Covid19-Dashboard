<?php
	session_start();
	$name=$_SESSION['name'];
	$gender="";
	$dob="";
	$mobno=$_SESSION['mobno'];
	$email="";
	$tablename="a$mobno";
	$status="open";
	date_default_timezone_set('Asia/Kolkata');
	// $date = date('Y/m/d', time());
	// $time = date('h:i:s a',time());
	// echo $date."<br>";
	// echo $time;
	if (isset($_SESSION['mobno'])) {
		// echo"Session";
		$serverName = ""; // update me
    	$connectionOptions = array(
        "Database" => "", // update me
        "Uid" => "", // update me
        "PWD" => "" // update me
    	);
	    //Establishes the connection
		$conn = sqlsrv_connect($serverName, $connectionOptions);
		if($conn==false){
		    die(print_r(sqlsrv_errors(), true));
		}else{
			// echo "connection success";
			// for check message table available or not;
			$sql="SELECT * FROM $tablename ORDER BY i";
			$results=sqlsrv_query($conn,$sql);
			if($results){  //chat table present
				// echo "Table is Present=>$mobno";
				// for load all basic info from user table;
				$sql2="SELECT * FROM users WHERE mobno='$mobno'";
				$results2=sqlsrv_query($conn,$sql2);
				$details2 = sqlsrv_fetch_array($results2,SQLSRV_FETCH_ASSOC);
				$gender=$details2['gender'];
				$dob=$details2['dob'];
				$email=$details2['email'];
				// print_r($email);

				// load all messages;
				// $details = sqlsrv_fetch_array($results,SQLSRV_FETCH_ASSOC);
				// print_r($details);
				// while( $row = sqlsrv_fetch_array($results,SQLSRV_FETCH_ASSOC) ) {
    //   				echo $row['sender'].", ".$row['message']."<br />";
				// }	
				

			}else if(!$results){
				$sql="CREATE TABLE $tablename(sender VARCHAR(10),message NVARCHAR(MAX),time VARCHAR(10),date VARCHAR(40), i Int);";
				$results=sqlsrv_query($conn,$sql);
				$sql2="INSERT INTO users(name,mobno,status)VALUES ('$name','$mobno','open')";
				$results2=sqlsrv_query($conn,$sql2);
				if($results2){

					echo "<script type='text/javascript'>alert('Now You Can Message Us')</script>";
				}
			}
			if (array_key_exists("save", $_POST)) {
				$name=$_REQUEST['name'];
				$gender=$_REQUEST['gender'];
				$dob=$_REQUEST['dob'];
				$email=$_REQUEST['email'];
				$mobno=$_REQUEST['mobno'];
				// print_r($name."=>".$gender."=>".$dob."=>".$email."=>".$mobno."=>".$status);
				$sql="UPDATE users SET name='$name',gender='$gender',dob='$dob',email='$email',status='open' WHERE mobno='$mobno'";
				$results=sqlsrv_query($conn,$sql);
				if($results){
					// echo "Data Inserted";
					
		    		session_unset();
		    		session_destroy();
		    		header("Location: index.php");
		    		exit();
				}else{
					echo "Data not Inserted";
				}
			}
			if(array_key_exists("send",$_POST)){
				// echo "Ready to insert message";
				$message = $_REQUEST['message'];
				// print_r($message);
				date_default_timezone_set('Asia/Kolkata');
				$date = date('d-m-Y', time());
				$time = date('H:i:s',time());
				// echo $message."=>".$time."=>".$date."=>".$i+1;
				$p="SELECT count(*) from $tablename;";
				$q=sqlsrv_query($conn,$p);
				$j=sqlsrv_fetch_array($q,SQLSRV_FETCH_ASSOC);
				// print_r($j['']);
				$i=$j['']+1;
				// echo $i;
				$sql="INSERT INTO $tablename(sender,message,time,date,i)VALUES ('U','$message','$time','$date','$i')";
				$results=sqlsrv_query($conn,$sql);
				if ($results){
					// echo "Inserted";
					header("Location: user-chat.php");
				}else{
					echo "Not Inserted";
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
	<title>Querry-Form</title>
	<link rel="stylesheet" href="user-chat-style.css?v=<?php echo time(); ?>">
	<!-- <link rel="stylesheet" type="text/css" href="Admin-style.css"> -->
	<!-- for font -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai+Looped:wght@500&display=swap" rel="stylesheet">
</head>
<body>
	<div class="top">
	<form method="POST">
		<div class="row-1">
			<fieldset>
				<legend>Name*</legend>
				<input type="text" name="name" required class="NME" value="<?php echo $name; ?>">
			</fieldset>
			<div class="gen">
			<label>Gender*</label>
				<select name="gender" >
					<option value="<?php echo $gender; ?>"><?php echo $gender.'(Choosen)'; ?></option>
					<option value="Male">Male</option>
				  	<option value="Female">Female</option>
				  	<option value="Others">Others</option>
				</select>
			</div>

			<div class="gen">
				<label>Date Of Birth*</label>
				<input type="date" required name="dob" id="date" value="<?php echo $dob; ?>">
			</div>

		</div>
		<div class="row-2">
			<fieldset>
				<legend>Mobile No*</legend>
				<input type="number" name="mobno" class="NME"  value="<?php echo $mobno; ?>" readonly>
			</fieldset>

			<fieldset>
				<legend>Email Id*</legend>
				<input type="email" name="email" value="<?php echo $email; ?>"required class="NME">
			</fieldset>
			<button name="save">Save&Exit</button>
		</div>
	</form>
	</div>
	<div class="container" id="chatbox">
		<?php 
			$date="";
			while( $row = sqlsrv_fetch_array($results,SQLSRV_FETCH_ASSOC) ) {
				// if($row['date']!=$date){
				// 	echo "<h1>".$row['date']."</h1>";
				// 	$date = $row['$date'];
				// }
      			if ($row['sender']=='A') {
      				// echo "<div class='A'><p>".$row['message']."</p></div>";
      				echo "<div class='A'><span>".$row['date']."</span><span>( ".$row['time']." )</span><p>".$row['message']."</p></div>";
      			}else{
      				echo "<div class='U'><p>".$row['message']."</p><span>".$row['time']."</span><span>( ".$row['date']." )</span></div>";

      			}
			}
			
		?>
	</div>
<form method="POST" class="bottom">
	<textarea placeholder ="Enter here message" name="message" required></textarea>
	<button name="send">Send</button>
</form>
<script type="text/javascript">
    var element = document.getElementById("chatbox");
    element.scrollTop = element.scrollHeight;
</script>
</body>
</html>

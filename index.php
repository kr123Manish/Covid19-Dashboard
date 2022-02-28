<?php
	if (array_key_exists("verify", $_POST)){
		// echo "Ready";
		$name=$_REQUEST['name'];
		$mobno=$_REQUEST['mobno'];
		session_start();
		$_SESSION['name']=$name;
		$_SESSION['mobno']=$mobno;
		echo $_SESSION['name']."=>".$_SESSION['mobno'];
		header("Location: user-chat.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>F&Q-Portal</title>
	<link rel="stylesheet" type="text/css" href="style.css">

	<!-- for font -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai+Looped:wght@500&display=swap" rel="stylesheet">


	<!-- for smooth scroll -->
	<script src="https://cdn.jsdelivr.net/gh/cferdinandi/smooth-scroll@15.0.0/dist/smooth-scroll.polyfills.min.js"></script>
</head>
<body>
		<div id="preloader"></div>
		<div class="banner">
			<div class="col-1">
				<a href="#chat-bot">Explore Chatbot</a>
				<a href="#message">Discuss with experts</a>
				<a href="admin.php">Login As Admin</a>
			</div>
			<img src="mail3.svg">
		</div>
		<div class="h1" id="chat-bot">
			<h1>Let's F&Q with chat-bot</h1>
		</div>
		<div class="container">

			<div class="img">
				<img src="mail2.svg">
			</div>
			<div class="frame">
				<iframe src='https://webchat.botframework.com/embed/fnq-bot-bot?s=nVRzANNhx30.rQ-R5gQNdoXTyrucaIq7B7saNQiQhWS42ykaHUw4BV8'></iframe>
			</div>
		</div>
		<div class="h1" id="message">
			<h1>Email us for more query</h1>
		</div>

		<div class="container-2">
			<div class="message">
				<form method="POST">
					
					<div class="combo">
						<label>Name:</label>
						<input type="text" name="name" placeholder="your name"required>
					</div>
					<div class="combo">
						<label>Mobile No:</label>
						<input type="number" name="mobno" placeholder="your mobile number" required>
					</div>
					<!-- <textarea placeholder="Enter you query here in detail" required></textarea> -->
					<button name="verify">Verify</button>
				</form>
			</div>
			<div class="img">
				<img src="mail4.svg">
			</div>
			
		</div>


		
		  <!-- for preloader -->
		<script type="text/javascript">
			var preloader=document.getElementById("preloader");
			window.addEventListener('load', function() {
			preloader.style.display="none";
			});
  		</script>

</body>
</html>
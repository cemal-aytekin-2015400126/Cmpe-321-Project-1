<html>
	<head>
		<title>Projects</title>
		<link rel="stylesheet" type="text/css" href="../design.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body>
	<?php 
		session_start();
		if(!isset($_SESSION['Username'])){
			$msg = "Please <a href = 'http://Localhost/Project_Management/AdminLogin.php'>log in</a> to view this page";
			echo $msg;
		}
		else{
			?>
		<div id="auth">
		<p align="center"><strong> Search Projects By Project Manager ID</strong> </p>
		<br>
		<p>Type ALL for all projects</p>
		<br>
		<form action="spAdminResultPage.php" method="POST">
				<p> Manager ID:</p> <input type="text" name="id" />
				<br>
				<input type="submit" />
		</form>
		</div>
		<?php
		}
		?>
	</body>
</html>
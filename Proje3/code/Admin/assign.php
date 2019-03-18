<html>
	<head>
	<link rel="stylesheet" type="text/css" href="../design.css">
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
		<div ="auth">
			<p align="center"><strong> Assign a Project Manager to a Project</strong> </p>
			<br>
			<br>
			<form action="assign_result.php" method="POST">
				<p> Manager ID: </p> <input type="text" name="ManagerID" />
				<p> Project ID: </p> <input type="text" name="ProjectID" />
				<br>
				<input type="submit" />
				<br>
			
			</form>
		</div>
		<?php
		}
		?>
	</body>
</html>
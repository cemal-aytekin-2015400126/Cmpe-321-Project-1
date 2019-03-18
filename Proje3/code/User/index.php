<html>
	<head>
	<link rel="stylesheet" type="text/css" href="../design.css">
	</head>
	<body>
		<?php 
		session_start();
		if(!isset($_SESSION['id'])){
			$msg = "Please <a href = 'http://Localhost/Project_Management/UserLogin.php'>log in</a> to view this page";
			echo $msg;
		}
		else{
			?>
			<div id="menu">
				<strong>Welcome to Project Manager Panel. Your ID: <?php echo $_SESSION['id'] ?> </strong>
				<br>
				<br>
				<br>
				<br>
				<a href="/Project_Management/User/ListTasks.php" >List Tasks</a>
				<br>
				<br>
				<a href="/Project_Management/User/spManager.php" >Search My Projects</a>
				<br>
				<br>
				<a href="/Project_Management/User/assign.php" >Assign an Employee to a Task</a>
				<br>
				<br>
				<br>
				<a href="/Project_Management/User/logout.php" style="background-color:red">Logout</a>
			</div>
		<?php
		}
		?>
	</body>

</html>
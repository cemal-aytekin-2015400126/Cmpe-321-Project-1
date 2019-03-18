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
		<div ="auth">
			<p align="center"><strong> Assign an Employee to a Task</strong> </p>
			<br>
			<br>
			<form action="assign_result.php" method="POST">
				<p> Employee ID: </p> <input type="text" name="EmployeeID" />
				<p> Task ID: </p> <input type="text" name="TaskID" />
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
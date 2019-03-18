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
			<div id="menu">
				<strong>Welcome <?php echo $_SESSION['Username'] ?> to Admin Panel </strong>
				<br>
				<br>
				<br>
				<br>
				<a href="/Project_Management/Admin/ListProjectManagers.php" >List Project Managers</a>
				<br>
				<br>
				<a href="/Project_Management/Admin/ListProjects.php">List Projects</a>
				<br>
				<br>
				<a href="/Project_Management/Admin/ListEmployees.php">List Employees</a>
				<br>
				<br>
				<a href="/Project_Management/Admin/assign.php">Assign Manager to a Project</a>
				<br>
				<br>
				<a href="/Project_Management/Admin/spAdmin.php">Search Project</a>
				<br>
				<br>
				<br>
				<a href="/Project_Management/Admin/logout.php" style="background-color:red">Logout</a>
			</div>
		<?php
		}
		?>
	</body>

</html>
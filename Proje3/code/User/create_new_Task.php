<html>
	<head>
		<title>New Task</title>
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
		<?php
			$servername = 'localhost';
			$username = "root";
			$password = "";
			$dbname = "cmpe321";
			
			//Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			
			//Check connection
			if($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			else{
				?>
				<div>
				<form action="create_new_Task_result.php" method="post">
				    <p>Project ID: <input type ="text" name="proid" value="" required /></p>
					<p>Name: <input type ="text" name="name" value="" required /></p>
					<p>Start Date(YYYY-MM-DD): <input type ="text" name="start" value="" required /></p>
					<p>Due Date(YYYY-MM-DD): <input type ="text" name="due" value="" required /></p>
					<p><input type ="submit" value = "Create Task"/></p>
				</form>
				</div>
			<?php
			}
			$conn->close();
		}
		?>
	</body>
</html>
					
					
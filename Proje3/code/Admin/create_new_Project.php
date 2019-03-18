 <html>
	<head>
		<title>New Project</title>
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
				<form action="create_new_Project_result.php" method="post">
					<p>Name: <input type ="text" name="name" value="" required /></p>
					<p>Start Date(YYYY-MM-DD): <input type ="text" name="start" value="" required /></p>
					<p>Due Date(YYYY-MM-DD): <input type ="text" name="due" value="" required /></p>
					<p><input type ="submit" value = "Create Projects"/></p>
				</form>
				</div>
			<?php
			}
			$conn->close();
		}
		?>
	</body>
</html>
					
					
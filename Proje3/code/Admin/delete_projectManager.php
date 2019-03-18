 <html>
	<head>
		<title>Delete Manager</title>
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
				$sql = "SELECT * FROM ProjectManagers WHERE UserID ="
				. $_GET["id"];
				$result = $conn->query($sql);
				
				if($result->num_rows > 0){
					?>			
				<p><strong> Are you sure to delete the following Project Manager</strong></p>
				<br>
				<br>
				<div>
				<form action="delete_projectManager_result.php" method="post">
				<?php
				$row = $result->fetch_assoc();
				?>
					<p>User ID: <input type ="text" name="id" value="<?php echo $row["UserID"] ?>" readonly /></p>
					<p>Name: <input type ="text" name="name" value="<?php echo $row["Name"] ?>" readonly /></p>
					<p>Surname: <input type ="text" name="surname" value="<?php echo $row["Surname"] ?>"readonly /></p>
					<p>Password: <input type ="text" name="password" value="<?php echo $row["Password"] ?>" readonly/></p>
					<p>Email: <input type ="text" name="email" value="<?php echo $row["Email"] ?>"readonly /></p>
					<p><input type ="submit" value = "Delete Manager"/></p>
				</form>
				</div>
				<?php
				}
				else{
					echo "Record does not exist";
				}
			}
			$conn->close();
		}
			?>
	</body>
</html>
					
					  
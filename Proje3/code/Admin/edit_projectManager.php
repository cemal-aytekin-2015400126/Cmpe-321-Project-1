 <html>
	<head>
		<title>Edit Manager</title>
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
				<div>
				<form action="edit_projectManager_result.php"  method="post">
				<?php
				$row = $result->fetch_assoc();
				?>
					<p>User ID:</p> <input type ="text" name="id" value="<?php echo $row["UserID"] ?>" readonly />
					<p>Name:</p> <input type ="text" name="name" value="<?php echo $row["Name"] ?>" />
					<p>Surname:</p> <input type ="text" name="surname" value="<?php echo $row["Surname"] ?>" />
					<p>Password: </p><input type ="text" name="password" value="<?php echo $row["Password"] ?>" />
					<p>Email:</p> <input type ="text" name="email" value="<?php echo $row["Email"] ?>" />
					<br>
					<input type ="submit" value = "Save Changes"/>
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
					
					 
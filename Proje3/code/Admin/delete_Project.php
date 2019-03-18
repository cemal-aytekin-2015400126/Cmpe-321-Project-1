 <html>
	<head>
		<title>Delete Project</title>
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
				$sql = "SELECT * FROM Projects WHERE ProjectID ="
				. $_GET["id"];
				$result = $conn->query($sql);
				
				if($result->num_rows > 0){
					?>			
				<p><strong> Are you sure to delete the following Project</strong></p>
				<br>
				<br>
				<div>
				<form action="delete_Project_result.php" method="post">
				<?php
				$row = $result->fetch_assoc();
				?>
					<p>Project ID: <input type ="text" name="id" value="<?php echo $row["ProjectID"] ?>" readonly /></p>
					<p>Name: <input type ="text" name="name" value="<?php echo $row["Name"] ?>" readonly /></p>
					<p>Start Date: <input type ="text" name="start" value="<?php echo $row["StartDate"] ?>" readonly/></p>
					<p>Due Date: <input type ="text" name="due" value="<?php echo $row["DueDate"] ?>"readonly /></p>
					<p><input type ="submit" value = "Delete Project"/></p>
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
					
					  
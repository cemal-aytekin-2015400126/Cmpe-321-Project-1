 <html>
	<head>
		<title>Edit project</title>
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
				$sql = "SELECT * FROM Tasks WHERE TaskID ="
				. $_GET["id"];
				$result = $conn->query($sql);
				
				if($result->num_rows > 0){
					?>	
				<div>
				<form action="edit_Task_result.php"  method="post">
				<?php
				$row = $result->fetch_assoc();
				?>
					<p>Task ID: <input type ="text" name="id" value="<?php echo $row["TaskID"] ?>" readonly /></p>
					<p>Project ID: <input type ="text" name="proid" value="<?php echo $row["ProjectID"] ?>" readonly /></p>
					<p>Name: <input type ="text" name="name" value="<?php echo $row["Name"] ?>"  /></p>
					<p>Start Date: <input type ="text" name="start" value="<?php echo $row["StartDate"] ?>" /></p>
					<p>Due Date: <input type ="text" name="due" value="<?php echo $row["DueDate"] ?>" /></p>
					<p><input type ="submit" value = "Edit Task"/></p>
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
					
					 
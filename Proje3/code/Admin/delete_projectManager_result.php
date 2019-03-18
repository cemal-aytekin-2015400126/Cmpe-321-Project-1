  <html>
	<head>
		<title>Result</title>
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
				//Insert te record
				$sql ="DELETE FROM ProjectManagers"
				." WHERE UserID = " . $_POST['id']; 
					
				if($conn->query($sql) === TRUE) {
					echo "Record has been deleted successfully from ProjectManagers<br/>";
				}
				else{
					echo "Error deleting record from ProjectManagers: " . $conn->error;
				}
				
				$sql2 = "DELETE FROM managertoproject"
				." WHERE ManagerID = " . $_POST['id']; 
				if($conn->query($sql2) === TRUE) {
					echo "Relation has been deleted successfully from Manager to Projects<br/>";
					echo "<a href='ListProjectManagers.php'>Go Back</a>";
				}
				else{
					echo "Error deleting record from relation: " . $conn->error;
				}
				
			}
			$conn->close();
		}
		?>
	</body>
</html>
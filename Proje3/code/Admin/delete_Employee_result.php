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
				$sql ="DELETE FROM Employees"
				." WHERE EmployeeID = " . $_POST['id']; 
					
				if($conn->query($sql) === TRUE) {
					echo "Record has been deleted successfully from Employees<br/>";
				}
				
				/*
				$sql3 ="DELETE FROM Tasks"
				." WHERE TaskID IN (SELECT TaskID FROM tasktoemployee WHERE EmployeeID = " . $_POST['id'].")"; 
					
				if($conn->query($sql3) === TRUE) {
					echo "Record has been deleted successfully from Tasks <br/>";
				}
				else{
					echo "Error deleting record: " . $conn->error;
				}
				
				$sql4 ="DELETE FROM projecttotask"
				." WHERE TaskID IN (SELECT TaskID FROM tasktoemployee WHERE EmployeeID = " . $_POST['id'].")"; 
					
				if($conn->query($sql4) === TRUE) {
					echo "Record has been deleted successfully from projecttotask <br/>";
				}
				else{
					echo "Error deleting record: " . $conn->error;
				}
				*/
				
				$sql2 = "DELETE FROM tasktoemployee"
				." WHERE EmployeeID = " . $_POST['id']; 
				
				if($conn->query($sql2) === TRUE) {
					echo "All task assignments on this employee are deleted!";
					echo "<a href='ListEmployees.php'>Go Back</a>";
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
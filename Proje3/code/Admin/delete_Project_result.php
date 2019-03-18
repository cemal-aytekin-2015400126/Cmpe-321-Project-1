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
				$sql ="DELETE FROM Projects"
				." WHERE ProjectID = " . $_POST['id']; 
					
				if($conn->query($sql) === TRUE) {
					echo "Record has been deleted successfully from Projects<br/>";
				}
				else{
					echo "Error deleting record: " . $conn->error;
				}
				
				$sql2 = "DELETE FROM managertoproject"
				." WHERE ProjectID = " . $_POST['id']; 
				
				if($conn->query($sql2) === TRUE) {
					echo "Relation has been deleted successfully from Manager to Projects<br/>";
				}
				
				else{
					echo "Error deleting record from relation: " . $conn->error;
				}
				
				$sql4="DELETE FROM tasktoemployee WHERE TaskID IN (SELECT TaskID FROM projecttotask WHERE ProjectID='". $_POST['id']."')";
				if($conn->query($sql4) === TRUE) {
				echo "All related tasktoemployee relations are deleted!<br/>";
				}
				else{
					echo "Error deleting record from relation: " . $conn->error;
				}
				
				$sql5="DELETE FROM Tasks WHERE TaskID IN (SELECT TaskID FROM projecttotask WHERE ProjectID='". $_POST['id']."')";
				if($conn->query($sql5) === TRUE) {
				echo "All related tasks are deleted!<br/>";
				}
				else{
					echo "Error deleting record from relation: " . $conn->error;
				}
					
				$sql3 = "DELETE FROM projecttotask"
				." WHERE ProjectID = " . $_POST['id']; 
				
				if($conn->query($sql3) === TRUE) {
					echo "All related projecttotask relations are deleted<br/>";
					echo "<a href='ListProjects.php'>Go Back</a>";
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
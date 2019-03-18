<html>
	<head>
		<title>Result</title>
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
				//Insert te record
				$sql ="INSERT INTO Tasks(ProjectID, Name, StartDate, DueDate)" .
					"VALUES('". $_POST['proid'] . "','". $_POST['name'] ."','". $_POST['start'] ."','". $_POST['due'] . "')";
					
				if($conn->query($sql) === TRUE){
					$sql2 ="INSERT INTO projecttotask(ProjectID,TaskID)" .
					"VALUES('". $_POST['proid'] . "','". $conn->insert_id ."')";
					if($conn->query($sql2) === TRUE){
					echo "Record has been created successfully <br/>";
					}
					else{
						echo "Error creating task: " . $conn->error;
					}
					echo "<a href='ListTasks.php'>Go Back</a>";
				}
				else{
					echo "Error creating task: " . $conn->error;
				}
			}	
			$conn->close();
		}
		?>
	</body>
</html>
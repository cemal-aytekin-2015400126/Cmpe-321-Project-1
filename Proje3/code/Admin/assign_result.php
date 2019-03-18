<?php 
	session_start();
	if(!isset($_SESSION['Username'])){
		$msg = "Please <a href = 'http://Localhost/Project_Management/AdminLogin.php'>log in</a> to view this page";
		echo $msg;
	}
	else{
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
			$sql ="INSERT INTO managertoproject(ManagerID, ProjectID)" .
				"VALUES('". $_POST['ManagerID'] . "','". $_POST['ProjectID'] . "')";
				
			if($conn->query($sql) === TRUE) {
				echo "Assignment has been done succesfully! <br/>";
				echo "<a href='index.php'>Go Back</a>";
			}
			else{
				echo "Error creating record: " . $conn->error;
			}
		}
		$conn->close();
	}
	?>
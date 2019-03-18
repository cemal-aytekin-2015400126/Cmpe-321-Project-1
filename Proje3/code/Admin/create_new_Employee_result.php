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
				$sql ="INSERT INTO Employees(Name, Surname, Salary)" .
					"VALUES('". $_POST['name'] . "','". $_POST['surname'] . "','". $_POST['salary'] . "')";
					
				if($conn->query($sql) === TRUE) {
					echo "Record has been created successfully <br/>";
					echo "<a href='ListEmployees.php'>Go Back</a>";
				}
				else{
					echo "Error creating record: " . $conn->error;
				}
			}
			$conn->close();
		}
		?>
	</body>
</html>
<?php 
	session_start();
	if(!isset($_SESSION['id'])){
		$msg = "Please <a href = 'http://Localhost/Project_Management/UserLogin.php'>log in</a> to view this page";
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
			
			$givenStart="";
			$givenEnd="";
			$sql3 = "SELECT * FROM Tasks WHERE TaskID = '".$_POST['TaskID']."'";
			$foo = TRUE;
			$result3 = $conn->query($sql3);
			if($result3->num_rows > 0){
				$row = $result3->fetch_assoc();
				$givenStart=$row['StartDate'];
				$givenEnd=$row['DueDate'];
			}
			
						
			$sql2 ="SELECT * FROM Tasks WHERE TaskID IN (SELECT TaskID FROM tasktoemployee WHERE EmployeeID='".$_POST['EmployeeID']."')";
			$result = $conn->query($sql2);
			if($result->num_rows > 0){
				$start="";
				$end="";
				while($row = $result->fetch_assoc()){
					
					$start=$row['StartDate'];
					$end=$row['DueDate'];
					
					if( ((strcmp($givenStart,$start)>0) and (strcmp($givenStart,$end) <0)) or
					    ((strcmp($givenEnd,$start)>0) and (strcmp($givenEnd,$end) <0)) and ($_POST['TaskID']!=$row['TaskID']) ){
							$foo = FALSE;
						}
				}
			}
			
			if($foo){
			//Insert te record
				$sql ="INSERT INTO tasktoemployee(TaskID, EmployeeID)" .
					"VALUES('". $_POST['TaskID'] . "','". $_POST['EmployeeID'] . "')";
					
					
					
				if($conn->query($sql) === TRUE) {
					echo "Assignment has been done succesfully! <br/>";
					echo "<a href='index.php'>Go Back</a>";
				}
				else{
					echo "Error creating record: " . $conn->error;
				}
			}
			else{
				?>
				<div margin-top="150px" color="red">
				<p align="center"><strong>UUUUPS! Cannot assign more than one task to an employee for the same time interval!</strong></p>
				<br>
				<a align="center" href='index.php'>Go Back</a>
				</div>
				<?php

			}
		}
		$conn->close();
	}
	?>
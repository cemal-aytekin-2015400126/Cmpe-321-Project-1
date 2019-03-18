<html>
	<head>
		<title>My Projects</title>
		<link rel="stylesheet" type="text/css" href="../design.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
		<p><strong> My Projects</strong></p>
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
				//List records
				$sql = "SELECT Projects.*,managertoproject.* FROM Projects, managertoproject
				WHERE Projects.ProjectID = managertoproject.ProjectID 
				AND managertoproject.ManagerID = '".$_SESSION['id'] ."'";
				
				$result = $conn->query($sql);
				
				if( $result->num_rows > 0){
					?>
					<table id="table1">
						<tr>
							<th>Project ID</th>
							<th>Name</th>
							<th>Start Date</th>
							<th>Due Date</th>
							<th>Status</th>
						</tr>
					<?php
					
					//output data of each row
					while($row = $result->fetch_assoc()){
						$status="completed";
						$projectEndDate = $row['DueDate'];

						$sql2 = "SELECT * FROM TASKS WHERE TaskID IN (SELECT TaskID FROM projecttotask WHERE ProjectID='".$row['ProjectID']."')";
						$result2 = $conn->query($sql2);		
						if( $result2->num_rows > 0){
							while($row2 = $result2->fetch_assoc()){
								$taskEndDate = $row2['DueDate'];
								if(strcmp($taskEndDate,$projectEndDate)>0){
									$status="Incompleted";
									break;
								}
							}
						}
						else{
							$status="incompleted";
						}
						
						?>
						<tr>
							<td><?php echo $row["ProjectID"]; ?></td>
							<td><?php echo $row["Name"]; ?></td>
							<td><?php echo $row["StartDate"]; ?></td>
							<td><?php echo $row["DueDate"]; ?></td>
							<td><?php echo $status ?></td>
						</tr>
						<?php
					}
				
				}
				else{
					echo "No result found!";
				}	
			}
			$conn->close();
		}
		?>
	</body>
</html>
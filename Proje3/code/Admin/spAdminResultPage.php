<html>
	<head>
		<title>Project Managers</title>
		<link rel="stylesheet" type="text/css" href="../design.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body>
	<?php 
		session_start();
		if(!isset($_SESSION['Username'])){
			$msg = "Please <a href = 'http://Localhost/Project_Management/AdminLogin.php'>log in</a> to view this page";
			echo $msg;
		}
		else{
			if($_POST['id'] == "ALL"){
				header("Location:ListProjects.php");
			}
			?>
	<p><strong> List of Projects with Project Manager ID: <?php echo $_POST['id']?></strong></p>
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
				$sql = "SELECT Projects.*, managertoproject.ProjectID FROM Projects,managertoproject WHERE Projects.ProjectID=managertoproject.ProjectID AND managertoproject.ManagerID= '".$_POST['id']."'";
				$result = $conn->query($sql);
								
				if( $result->num_rows > 0){
					?>
					<table id="table1">
						<tr>
							<th>Operations </th>
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
							<td>
							<a href = "delete_project.php?id=<?php echo $row["ProjectID"]; ?>"><i class="fa fa-close"></i></a>
							<a href = "edit_project.php?id=<?php echo $row["ProjectID"]; ?>"><i class="fa fa-edit"></i></a>
							
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
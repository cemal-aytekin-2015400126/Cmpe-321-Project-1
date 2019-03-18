<html>
	<head>
		<title>Tasks</title>
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
	<p><strong> List of Tasks</strong></p>
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
				$sql = "SELECT Tasks.*,projecttotask.*,managertoproject.*
				FROM Tasks, projecttotask, managertoproject 
				WHERE Tasks.TaskID=projecttotask.TaskID 
				AND projecttotask.ProjectID=managertoproject.ProjectID
				AND managertoproject.ManagerID ='".$_SESSION['id']."'";
				$result = $conn->query($sql);				
				if( $result->num_rows > 0){
					?>
					<table id="table1">
						<tr>
							<th>Operations </th>
							<th>Task ID</th>
							<th>Project ID</th>
							<th>Name</th>
							<th>Start Date</th>
							<th>Due Date</th>
						</tr>
					<?php
					
					//output data of each row
					while($row = $result->fetch_assoc()){
						?>
						<tr>
							<td>
							<a href = "delete_Task.php?id=<?php echo $row["TaskID"]; ?>"><i class="fa fa-close"></i></a>
							<a href = "edit_Task.php?id=<?php echo $row["TaskID"]; ?>"><i class="fa fa-edit"></i></a>
							<td><?php echo $row["TaskID"]; ?></td>
							<td><?php echo $row["ProjectID"]; ?></td>
							<td><?php echo $row["Name"]; ?></td>
							<td><?php echo $row["StartDate"]; ?></td>
							<td><?php echo $row["DueDate"]; ?></td>
						</tr>

					<?php
					}
					?>
					</table>
					<br>
					<br>
					<a href = "create_new_Task.php"> <i class="fa fa-plus" style="color:white"> Add new Task </i></a>
					<?php
				}
				else{
					echo "No result found!";
					?>
					<a href = "create_new_Task.php"> <i class="fa fa-plus" style="color:white"> Add new Task </i></a>
					<?php
				}	
			}
			$conn->close();
		}
		?>
	</body>
</html> 
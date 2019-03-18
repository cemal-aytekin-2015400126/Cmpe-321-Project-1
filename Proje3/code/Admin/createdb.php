 if ($result = $mysqli->query("SHOW TABLES LIKE ProjectManagers")) {
					if($result->num_rows == 1) {
						echo "Table exists";
					}
				}
				else {
					$createTable = "
					CREATE TABLE ProjectManagers (
						UserID int,
						Name varchar(255),
						Surname varchar(255),
						Email varchar(255),
						CurrentProjects varchar(255) 
					);";
				}
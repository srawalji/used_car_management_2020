<?php
	session_start();
	
	include('../mysqlconn.php'); 
?>

<!DOCTYPE html>
<html>
	<head>
		<title>National University Car Dealership System</title>
		<meta charset="utf8">
		<link rel="stylesheet" type="text/css" href="../styles/style.css?">
	</head>

	<body>
		<header>
			<?php include('../header.php'); ?>
		</header>
		
		<div id="container">
			<div class="col-2 nav">
				<?php include('../nav/admin/admin-manage-vehicle-makes-nav.php'); ?>
			</div>
			
			<div class="col-9 content">
				<?php include('../logged-in-as.php'); ?>
				<h2>Vehicle Makes</h2>
				<?php 
				$sql = "SELECT * FROM makes";
				$result = mysqli_query($mysqlconn, $sql);
				if(mysqli_num_rows($result) > 0)
				{
					echo '<table> <tr><th>Edit</th> <th>Delete</th> <th>Name</th> </tr>';
					while($row = mysqli_fetch_assoc($result))
					{
						echo '<tr>
								<td><a href="admin-edit-vehicle-make.php?id=' . $row["id"] . '">Edit</a></td> 
								<td><a href="admin-delete-vehicle-make.php?id=' . $row["id"] . '">Delete</a></td> 
								<td>' . $row["name"] . '</td></tr>';
					}
					echo '</table>';
				}
				?>
			</div>
		</div>

		<footer>
			<?php include('../footer.php'); ?>
		</footer>
	</body>

</html>
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
				<?php include('../nav/admin/admin-manage-users-nav.php');?>
			</div>
			<div class="col-9 content">
				<?php include('../logged-in-as.php'); ?>
				<h2>Registered Users</h2>
				<?php 
					$sql = "SELECT user_id, user_name, last_name, first_name, email, 
									DATE_FORMAT(registration_date, '%M, %d, %Y') as registration_date
							FROM users";
					$result = mysqli_query($mysqlconn, $sql);
					if(mysqli_num_rows($result) > 0)
					{
						echo '<table> 
								<tr><th>Edit</th> 
									<th>Delete</th> 
									<th>Name</th> 
									<th>Username</th> 
									<th>Email</th> 
									<th>Date Registered</th>
								</tr>';
						while($row = mysqli_fetch_assoc($result))
						{
							if($row["user_name"] != ($_SESSION['user_name']))
							{
								echo'<tr>
										<td><a href="admin-edit-user.php?id=' . $row['user_id'] . '">Edit</a></td> 
										<td><a href="admin-delete-user.php?id=' . $row['user_id'] . '">Delete</a></td> 
										<td>' . $row["last_name"] . ', ' . $row["first_name"] . '</td> 
										<td>' . $row["user_name"] . '</td> <td>' . $row["email"] . '</td>
										<td>' . $row["registration_date"] . '</td>
									 </tr>';
							}
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
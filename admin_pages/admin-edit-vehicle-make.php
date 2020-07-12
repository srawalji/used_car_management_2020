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
			
			<div class=" col-9 content formContent">
				<?php include('../logged-in-as.php');?>
				<?php $id = $_GET['id'];?>
				<h2>Edit Vehicle Make</h2>
				<?php
					if ($_SERVER['REQUEST_METHOD'] == 'POST')
					{
						$makeName = $_POST['make_name'];
					
						$query = "UPDATE makes
								SET name = ?
								WHERE id = ?";
					
						$preparedStmt = @mysqli_prepare($mysqlconn, $query);
						if (@mysqli_stmt_bind_param($preparedStmt, 
													"si", 
													$makeName,
													$id) &&
							@mysqli_stmt_execute($preparedStmt))
						{
							@mysqli_stmt_close($preparedStmt); 
							header("Location: admin-manage-vehicle-makes.php");
						} 
						else
						{
							$query = "UPDATE makes
								SET name = '$makeName'
								WHERE id = '$id'";
							echo '<p class="error">This page has been accessed in error.</p>';
							echo "<p>" . @mysqli_error($mysqlconn) . "<br><br/>Query: " . $query . "</p>";                            
						}                      
					}
				
					$query = "SELECT name
						FROM makes
						WHERE id = ?";
								
					$preparedStmt = @mysqli_prepare($mysqlconn, $query);
					if (@mysqli_stmt_bind_param($preparedStmt, "i", $id)    && 
						@mysqli_stmt_execute($preparedStmt)                 &&
						@mysqli_stmt_bind_result($preparedStmt,
												 $makeName))
					{
						@mysqli_stmt_fetch($preparedStmt);
						@mysqli_stmt_close($preparedStmt); 
						
						echo '
						<form action="' . $_SERVER['PHP_SELF'] . '?id=' . $id . '" method="post">
						Vehicle Make: <input type="text" name="make_name" value="' . $makeName . '"><br><br>
						<br>
							<input type="submit" name="edit" value="Edit">
						</form>';           
					}
					else 
					{ 
						$query = "SELECT name
						FROM makes
						WHERE id = '$id'";
							  
						echo '<p class="error">This page has been accessed in error.</p>';
						echo "<p>" . @mysqli_error($mysqlconn) . "<br><br/>Query: " . $query . "</p>";
					}  
				?>
			</div>
		</div>

		<footer>
			<?php include('../footer.php'); ?>
		</footer>
	</body>

</html>
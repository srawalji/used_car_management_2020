<?php
	session_start();
	
	include '../mysqlconn.php';
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
			<?php include('../nav/admin/admin-manage-users-nav.php'); ?>
		</div>
		
		<div class="col-9 content formContent">
			<?php include('../logged-in-as.php'); ?>
			<?php $id = $_GET['id'];?>
			<?php
				if ($_SERVER['REQUEST_METHOD'] == 'POST')
				{
					if(isset($_POST['yes']))
					{
						$query = "DELETE FROM users WHERE user_id = ?";
						$preparedStmt = @mysqli_prepare($mysqlconn, $query);
						if (@mysqli_stmt_bind_param($preparedStmt, "i", $id) && 
							@mysqli_stmt_execute($preparedStmt))
						{
							header("Location: admin-manage-users.php");
							exit();
						}
						else
						{
							$query = "DELETE FROM users WHERE user_id = $id"; 
							$mySqlError = mysqli_error($mysqlconn);
							echo "<p class='error'>The selected pet could not be deleted due to a system error. We apologize for any inconvenience.</p>"; 
							echo "<p>" . $mySqlError . "<br/>Query: " . $query . "</p>";                             
						}   
					}
					if(isset($_POST['no']))
					{
						header("Location: admin-manage-users.php");
					}
				}
				
				$query = "SELECT first_name, last_name FROM users WHERE user_id = ?";
							
				$preparedStmt = @mysqli_prepare($mysqlconn, $query);
				if (@mysqli_stmt_bind_param($preparedStmt, "i", $id)    && 
					@mysqli_stmt_execute($preparedStmt)                 &&
					@mysqli_stmt_bind_result($preparedStmt,
											 $firstName,
											 $lastName													
												))
				{
					@mysqli_stmt_fetch($preparedStmt);
					@mysqli_stmt_close($preparedStmt); 
					
					echo '
						<h2>Delete User</h2>
						<br>
						<form action="' . $_SERVER['PHP_SELF'] . '?id=' . $id . '" method="post">
							Are you sure you want to permanently delete ' . $firstName . ' ' . $lastName . ' ?
							<br><br>
							<input type="submit" name="yes" value="Yes">
							<input type="submit" name="no" value="No">
						</form>
					';             
				}
				
				else 
				{ 
					$query = "SELECT first_name, last_name FROM users WHERE user_id = '$id'";
						  
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
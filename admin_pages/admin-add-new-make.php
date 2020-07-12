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
			
			<div class="col-9 content formContent">
				<?php include('../logged-in-as.php'); ?>
				<?php
					if ($_SERVER["REQUEST_METHOD"] == "POST")
					{    
						$makeName = $_POST['make_name'];
						$query = "INSERT INTO makes (name)
									VALUES(?)";
						$preparedStmt = @mysqli_prepare($mysqlconn, $query);
						if (@mysqli_stmt_bind_param($preparedStmt, 
													"s", 
													$makeName) 
												   &&
							@mysqli_stmt_execute($preparedStmt))
						{
							header("Location: admin-manage-vehicle-makes.php");
							exit();
						}
						
						else
						{
							$query = "INSERT INTO makes (name)
									VALUES('$makeName')";
									  
							$mySqlError = mysqli_error($mysqlconn);
							echo "<p class='error'>The information of the selected pet could not be added due to a system error. We apologize for any inconvenience.</p>"; 
							echo "<p>" . $mySqlError . "<br/>Query: " . $query . "</p>";                            
						}
					}
				?>
				<h2>Add Vehicle Make</h2>
				<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
					<div class="field">
						<label>Vehicle Make: </label>
						<input type="text" name="make_name">
					</div>
					
					<div class="field">
						<input type="submit" name="add" value="Add">
					</div>
				</form>
			</div>
		</div>

		<footer>
			<?php include('../footer.php'); ?>
		</footer>
	</body>

</html>
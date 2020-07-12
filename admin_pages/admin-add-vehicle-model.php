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
				<?php include('../nav/admin/admin-manage-vehicle-models-nav.php'); ?>
			</div>
			
			<div class="col-9 content formContent">
				<?php include('../logged-in-as.php'); ?>
				<?php
					if($_SERVER['REQUEST_METHOD'] == 'POST')
					{
						$modelName = $_POST['model_name'];
						$makeId = $_POST['make_select'];
						$query = "INSERT INTO models (name, make_id) VALUES ('$modelName', '$makeId')";
						
						if(!mysqli_query($mysqlconn, $query))
						{
							die('Error: ' . mysqli_error($mysqlconn));
						}
						else
						{
							header("Location: admin-manage-vehicles.php");
						}
						
						mysqli_close($mysqlconn);
					}

					$makeSelectOptions = "";
					$query = "SELECT id, name
								FROM makes";
					$result = @mysqli_query($mysqlconn, $query);
					if ($result)
					{
						$makeSelectOptions = "Vehicle Make: &nbsp;<select name='make_select' id='make_select' required>";
						while ($row = @mysqli_fetch_array($result, MYSQLI_BOTH))
						{
							$makeSelectOptions .= "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
						}           
						$makeSelectOptions .= "</select><br><br>";                             
						@mysqli_free_result($result); 
					}						
											
			
					echo '
						<br>
						<h2>Add Vehicle Model</h2>
						<br>
						<form action="' . $_SERVER['PHP_SELF'] . '"  method="post">
							<div class="field">
								<label>Vehicle Model: </label>
								<input type="text" name="model_name">
							</div>
						';
					echo $makeSelectOptions;
					echo '	
						<div class="field">
							<input type="submit" name="add" value="Add">
						</div>
					</form>
					
					';
				?>
			</div>
		</div>

		<footer>
			<?php include('../footer.php'); ?>
		</footer>
	</body>

</html>
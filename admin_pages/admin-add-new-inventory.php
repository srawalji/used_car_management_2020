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
				<?php include('../nav/admin/admin-manage-inventory-nav.php'); ?>
			</div>
			<div class="col-9 content formContent">
				<?php include('../logged-in-as.php'); ?>
				<?php
					if ($_SERVER["REQUEST_METHOD"] == "POST")
					{     
						$model = $_POST['model_select'];
						$year = $_POST['year'];
						$color = $_POST['color'];
						$vin = $_POST['vin'];
						$type = $_POST['type_select'];
						$powerType = $_POST['power_type_select'];
						$purchasedDate = $_POST['purchased_date'];
						$purchasedPrice = $_POST['purchased_price'];
						$soldDate = $_POST['sold_date'];
						$soldPrice = $_POST['sold_price'];
						$addCost = $_POST['additional_cost'];
						
						$query = "INSERT INTO vehicles (model_id, year, vehicle_type_id, vehicle_power_type_id, vin,
									dealer_purchased_date, dealer_purchased_price, sold_date, sold_price,
									additional_cost, color)
									VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
						$preparedStmt = @mysqli_prepare($mysqlconn, $query);
						if (@mysqli_stmt_bind_param($preparedStmt, 
													"iiiiisdsdds", 
													$model,
													$year,													
													$type,
													$powerType,													
													$vin,
													$purchasedDate,
													$purchasedPrice,
													$soldDate,
													$soldPrice,
													$addCost,
													$color) 
													
												   &&
							@mysqli_stmt_execute($preparedStmt))
						{
							header("Location: admin-manage-inventory.php");
							exit();
						}
						
						else
						{
							$query = "INSERT INTO vehicles (model_id, year, vehicle_type_id, vehicle_power_type_id, vin,
									dealer_purchased_date, dealer_purchased_price, sold_date, sold_price,
									additional_cost, color)
									VALUES('$model', '$year', '$type', '$powerType', '$vin', '$purchasedDate', '$purchasedPrice', 
											'$soldDate', '$soldPrice', '$addCost', '$color')";
									  
							$mySqlError = mysqli_error($mysqlconn);
							echo "<p class='error'>The information of the selected pet could not be added due to a system error. We apologize for any inconvenience.</p>"; 
							echo "<p>" . $mySqlError . "<br/>Query: " . $query . "</p>";                            
						}
					}
					
					
					$modelSelectOptions = "";
					$query = "SELECT mo.name as model_name, ma.name as make_name, mo.id as model_id
								FROM models mo, makes ma
								WHERE mo.make_id = ma.id";

					$result = @mysqli_query($mysqlconn, $query);
					if ($result)
					{
						$modelSelectOptions = "Model: &nbsp;<select name='model_select' id='model_select' required>";
						while ($row = @mysqli_fetch_array($result, MYSQLI_BOTH))
						{
							$modelSelectOptions .= "<option value='" . $row["model_id"] . "'>" . $row["model_name"] . " ( " . $row["make_name"] . " ) </option>";
						}           
						$modelSelectOptions .= "</select><br>";                             
						@mysqli_free_result($result); 
					}
					
					$typeSelectOptions = "";
					$query = "SELECT *
								FROM vehicle_types";

					$result = @mysqli_query($mysqlconn, $query);
					if ($result)
					{
						$typeSelectOptions = "Type: &nbsp;<select name='type_select' id='type_select' required>";
						while ($row = @mysqli_fetch_array($result, MYSQLI_BOTH))
						{
							$typeSelectOptions .= "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
						}           
						$typeSelectOptions .= "</select><br><br>";                             
						@mysqli_free_result($result); 
					}
					
					$powerTypeSelectOptions = "";
					$query = "SELECT *
								FROM vehicle_power_types";

					$result = @mysqli_query($mysqlconn, $query);
					if ($result)
					{
						$powerTypeSelectOptions = "Type: &nbsp;<select name='power_type_select' id='power_type_select' required>";
						while ($row = @mysqli_fetch_array($result, MYSQLI_BOTH))
						{
							$powerTypeSelectOptions .= "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
						}           
						$powerTypeSelectOptions .= "</select><br>";                             
						@mysqli_free_result($result); 
					}
					
					$currentPhpPage = $_SERVER['PHP_SELF'];
				
					echo '<h2>Add Vehicle Inventory</h2><br>';
				
					echo '<form action="' . $currentPhpPage . '" method="post">';
					echo $modelSelectOptions;
					
					echo '<p><label>Year: &nbsp;</label><input id="year" type="text" name="year" ></p>
						  <p><label>Color: &nbsp;</label><input id="color" type="text" name="color" ></p>
						  <p><label>VIN: &nbsp;</label><input id="vin" type="text" name="vin" ></p>';
						
					echo $typeSelectOptions;
					echo $powerTypeSelectOptions;			
					
					echo ' <p><label>Purchased Date: &nbsp;</label><input  id="purchased_date" type="date" name="purchased_date" ></p>
							<p><label>Purchased Price: &nbsp;</label><input  id="purchased_price" type="text" name="purchased_price"  ></p>
							<p><label>Sold Date: &nbsp;</label><input  id="sold_date" type="date" name="sold_date" ></p>
							<p><label>Sold Price: &nbsp;</label><input  id="sold_price" type="text" name="sold_price" ></p>
							<p><label>Additional Cost: &nbsp;</label><input  id="additional_cost" type="text" name="additional_cost" ></p>
											
							<p>&nbsp;</p>
							<p><input id="submit" type="submit" name="submit" value="Add"></p><br>
							<input type="hidden" name="id" ><br>
						  </form>';        
		   
				?>
			</div>
		</div>

		<footer>
			<?php include('../footer.php'); ?>
		</footer>
	</body>

</html>
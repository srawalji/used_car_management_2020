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
				<?php $id = $_GET['id'];?>
				<?php
					if ($_SERVER["REQUEST_METHOD"] == "POST")
					{     
						$vehicleId = $_POST["vehicle_id"];
						$modelId = $_POST['model_select'];
						$make = '';
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

						$query = "UPDATE vehicles 
								  SET model_id = ?, 
									  year = ?, 
									  vehicle_type_id = ?, 
									  vehicle_power_type_id = ?,
									  vin = ?,
									  dealer_purchased_date = ?,
									  dealer_purchased_price = ?,
									  sold_date = ?,
									  sold_price = ?,
									  additional_cost = ?,
									  color = ?
								  WHERE vehicle_id = ?";
						$preparedStmt = @mysqli_prepare($mysqlconn, $query);
						if (@mysqli_stmt_bind_param($preparedStmt, 
													"iiiissdsddsi", 
													$modelId, 
													$year, 
													$type,
													$powerType,													
													$vin, 
													$purchasedDate,
													$purchasedPrice,
													$soldDate,
													$soldPrice,
													$addCost,
													$color,
													$vehicleId) &&
							@mysqli_stmt_execute($preparedStmt))
						{
							@mysqli_stmt_close($preparedStmt); 
							header("Location: admin-manage-inventory.php");
						} 
						else
						{
							$query = "UPDATE vehicles 
								  SET model_id = '$modelId', 
									  year = '$year', 
									  vehicle_type_id = '$type', 
									  vehicle_power_type_id = '$powerType',
									  vin = '$vin',
									  dealer_purchased_date = '$purchasedDate',
									  dealer_purchased_price = '$purchasedPrice',
									  sold_date = '$soldDate',
									  sold_price = '$soldPrice',
									  additional_cost = '$addCost',
									  color = '$color'
								  WHERE vehicle_id = '$vehicleId'";
							echo '<p class="error">This page has been accessed in error.</p>';
							echo "<p>" . @mysqli_error($mysqlconn) . "<br><br/>Query: " . $query . "</p>";                            
						}                      
					}
					
					
					$query = "SELECT v.vehicle_id, ma.name as make_name, mo.id as model_id, vt.id as vehicle_type,
								vpt.id as vehicle_power_type, 
								DATE_FORMAT(v.dealer_purchased_date, '%Y-%m-%d') AS purchased_date, 
								v.dealer_purchased_price,
								DATE_FORMAT(v.sold_date, '%Y-%m-%d') AS sold_date, 
								v.sold_price, v.additional_cost, v.color, v.vin, v.year
						FROM vehicles v, makes ma, models mo, vehicle_types vt, vehicle_power_types vpt
						WHERE mo.make_id = ma.id AND v.model_id = mo.id AND v.vehicle_type_id = vt.id
								AND v.vehicle_power_type_id = vpt.id AND v.vehicle_id = ?";
								
					$preparedStmt = @mysqli_prepare($mysqlconn, $query);
					if (@mysqli_stmt_bind_param($preparedStmt, "i", $id)    && 
						@mysqli_stmt_execute($preparedStmt)                 &&
						@mysqli_stmt_bind_result($preparedStmt,
												 $vehicleId,
												 $makeName,
												 $modelId,													
													$type,
													$powerType,													
													$purchasedDate,
													$purchasedPrice,
													$soldDate,
													$soldPrice,
													$addCost,
													$color,
													$vin,
													$year))
					{
						@mysqli_stmt_fetch($preparedStmt);
						@mysqli_stmt_close($preparedStmt); 
						
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
									if($modelId == $row["model_id"])
									{
										$modelSelectOptions .= "<option value='" . $row["model_id"] . "' selected>" . $row["model_name"] . " ( " . $row["make_name"] . " ) </option>";
									}
									else
									{
										$modelSelectOptions .= "<option value='" . $row["model_id"] . "'>" . $row["model_name"] . " ( " . $row["make_name"] . " ) </option>";
										
									}
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
									if($type == $row["id"])
									{
										$typeSelectOptions .= "<option value='" . $row["id"] . "' selected>" . $row["name"] . "</option>";
									}				
									else
									{
										$typeSelectOptions .= "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
										
									}
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
									if($powerType == $row["id"])
									{
										$powerTypeSelectOptions .= "<option value='" . $row["id"] . "' selected>" . $row["name"] . "</option>";
									}				
									else
									{
										$powerTypeSelectOptions .= "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
										
									}
								}           
								$powerTypeSelectOptions .= "</select><br>";                             
								@mysqli_free_result($result); 
							}
					
	
							$currentPhpPage = $_SERVER['PHP_SELF'];
						
							echo '<h2>Edit Vehicle Inventory</h2><br>';
						
							echo '<form action="' . $currentPhpPage . '?id=' . $id . '" method="post">';
							echo $modelSelectOptions;
							
							echo '<p><label>Year: &nbsp;</label><input id="year" type="text" name="year" value="' . $year . '"></p>
								  <p><label>Color: &nbsp;</label><input id="color" type="text" name="color" value="' . $color . '"></p>
								  <p><label>VIN: &nbsp;</label><input id="vin" type="text" name="vin" value="' . $vin . '"></p>';
								
							echo $typeSelectOptions;
							echo $powerTypeSelectOptions;			
							
							echo '<p><label>Purchased Date: &nbsp;</label><input  id="purchased_date" type="date" name="purchased_date" value="' . $purchasedDate . '"></p>
										<p><label>Purchased Price: &nbsp;</label><input  id="purchased_price" type="text" name="purchased_price" value="' . $purchasedPrice . '"></p>
										<p><label>Sold Date: &nbsp;</label><input  id="sold_date" type="date" name="sold_date" value="' . $soldDate . '"></p>
										<p><label>Sold Price: &nbsp;</label><input  id="sold_price" type="text" name="sold_price" value="' . $soldPrice . '" ></p>
										<p><label>Additional Cost: &nbsp;</label><input  id="additional_cost" type="text" name="additional_cost" value="' . $addCost . '"></p>
														
										<p>&nbsp;</p>
										<p><input id="submit" type="submit" name="submit" value="Edit"></p><br>
										<p><input type="number" name="vehicle_id" id="vehicle_id" value="' . $vehicleId . '"hidden></p><br>
									  </form>';   		   
						
						
						/*else
						{
							echo '<p class="error">This page has been accessed in error.</p>';
							echo "<p>" . @mysqli_error($dbcon) . "<br><br/>Query: " . $query . "</p>";                              
						}   */                    
					}
					
					else 
					{ 
						$query = "SELECT v.vehicle_id, ma.name as make_name, mo.name as model_name, vt.name as vehicle_type,
								vpt.name as vehicle_power_type, v.dealer_purchased_date, v.dealer_purchased_price,
								v.sold_date, v.sold_price, v.additional_cost, v.color
						FROM vehicles v, makes ma, models mo, vehicle_types vt, vehicle_power_types vpt
						WHERE mo.make_id = ma.id AND v.model_id = mo.id AND v.vehicle_type_id = vt.id
								AND v.vehicle_power_type_id = vpt.id AND v.vehicle_id = '$id'";
							  
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
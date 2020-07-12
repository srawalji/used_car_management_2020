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
				<?php include('../nav/admin/admin-manage-inventory-nav.php'); ?>
			</div>
			<div class="col-9 content">
				<?php include('../logged-in-as.php'); ?>
				<h2>Vehicle Inventory</h2>
				<?php 
					$sql = "SELECT v.vehicle_id, ma.name as make_name, mo.name as model_name, vt.name as vehicle_type,
									vpt.name as vehicle_power_type, 
									DATE_FORMAT(v.dealer_purchased_date, '%M, %d, %Y') AS purchased_date,
									v.dealer_purchased_price, 
									DATE_FORMAT(v.sold_date, '%M, %d, %Y') AS sold_date,
									v.sold_price, v.additional_cost, v.color
							FROM vehicles v, makes ma, models mo, vehicle_types vt, vehicle_power_types vpt
							WHERE mo.make_id = ma.id AND v.model_id = mo.id AND v.vehicle_type_id = vt.id
									AND v.vehicle_power_type_id = vpt.id";

					$result = mysqli_query($mysqlconn, $sql);
					if(mysqli_num_rows($result) > 0)
					{
						echo '<table> 
								<tr>
								<th>Edit</th> <th>Delete</th> <th>Make</th> <th>Model</th> <th>Color</th> 
								<th>Type</th> <th>Power</th> <th>Purchased Date</th> <th>Purchased Price</th> 
								<th>Sold Date</th> <th>Sold Price</th> <th>Additional Cost</th>
								</tr>';
						while($row = mysqli_fetch_assoc($result))
						{
							echo '<tr>
									<td><a href="admin-edit-inventory.php?id=' . $row['vehicle_id'] . '">Edit</a></td> 
									<td><a href="admin-delete-inventory.php?id=' . $row['vehicle_id'] . '">Delete</a></td> 
									<td>' . $row["make_name"] . '</td> 
									<td>' . $row["model_name"] . '</td> 
									<td>' . $row["color"] . '</td>
									<td>' . $row["vehicle_type"] . '</td>
									<td>' . $row["vehicle_power_type"] . '</td>
									<td>' . $row["purchased_date"] . '</td>
									<td>' . $row["dealer_purchased_price"] . '</td>
									<td>' . $row["sold_date"] . '</td>
									<td>' . $row["sold_price"] . '</td>
									<td>' . $row["additional_cost"] . '</td>
									</tr>';
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
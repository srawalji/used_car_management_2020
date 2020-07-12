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
			<?php include('../nav/admin/admin-manage-vehicles-nav.php'); ?>
		</div>
		
		<div class="col-9 content">
			<?php include('../logged-in-as.php'); ?>
			<br>
			<table>
				<tr>
					<th>Domestic</th>
					<th>Foreign</th>
					<th>European</th>
				</tr>
				
				<tr>
					<td>
						<img src="../images/domestic.jpg">
					</td>
					
					<td>
						<img src="../images/foreign.jpg">
					</td>
					
					<td>
						<img src="../images/european.jpg">
					</td>
				</tr>
			</table>
		</div>
	</div>

	<footer>
		<?php include('../footer.php'); ?>
	</footer>
</body>

</html>
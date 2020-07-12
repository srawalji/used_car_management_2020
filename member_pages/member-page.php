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
			<?php include('../nav/member/member-page-nav.php'); ?>
		</div>
		
		<div class="col-9 content">
			<?php include('../logged-in-as.php'); ?>
			<img src="../images/autos-shares.jpg">
		</div>
	</div>

	<footer>
		<?php include('../footer.php'); ?>
	</footer>
</body>

</html>

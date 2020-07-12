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
				<?php include('../nav/admin/admin-manage-users-nav.php');?>
			</div>
			<?php
				if($_SERVER['REQUEST_METHOD'] == 'POST')
				{
					$username = $_POST['username'];
					$firstname = $_POST['firstname'];
					$lastname = $_POST['lastname'];
					$emailaddress = $_POST['emailaddress'];
					$password = SHA1($_POST['password']);
					$regdate = date("Y-m-d H:i:s");
					if(isset($_POST['isadmin']))
					{
						$isadmin = 1;
					}
					else
					{
						$isadmin = 0;
					}
					
					$sql = mysqli_prepare($mysqlconn, "INSERT INTO users (user_name, first_name, last_name, email, password, is_admin, registration_date)
								VALUES (?,?,?,?,?,?,?)");
					
					mysqli_stmt_bind_param($sql, "sssssis", $username, $firstname, $lastname, $emailaddress, $password, $isadmin, $regdate);

					if(mysqli_stmt_execute($sql))
					{
						mysqli_stmt_close($sql);

						mysqli_close($mysqlconn);
						
						header("Location: admin-manage-users.php");
					}
					else
					{
						die('Error: ' . mysqli_error($mysqlconn));
					}
				}
			?>
			
			<div class="col-9 content formContent">
				<?php include('../logged-in-as.php'); ?>
				<h2>Add User</h2><br>
				<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
					<div class="field">
						<label>User Name: </label>
						<input type="text" id="user-name" name="username" required>
					</div>
					<div class="field">		
						<label>First Name: </label>
						<input type="text" id="first-name" name="firstname" required>
					</div>
					<div class="field">	
						<label>Last Name: </label>
						<input type="text" id="last-name" name="lastname" required>
					</div>
					<div class="field">
						<label>Email Address: </label>
						<input type="text" id="email-address" name="emailaddress" required>
					</div>
					<div class="field">
						<label>Password: </label>
						<input type="password" id="password" name="password" required>
					</div>
					<div class="field">	
						<label>Is Admin </label>
						<input type="checkbox" id="isadmin" name="isadmin">
					</div>
					<div class="field">	
						<input type="submit" id="submit" name="submit" value="Add">
					</div>
				</form>
			</div>
		</div>

		<footer>
			<?php include('../footer.php'); ?>
		</footer>
	</body>

</html>
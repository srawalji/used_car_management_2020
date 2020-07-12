<!DOCTYPE html>
<html>
	<head>
		<?php include 'mysqlconn.php';?>
		<title>National University Car Dealership System</title>
		<meta charset="utf8">
		<link rel="stylesheet" type="text/css" href="styles/style.css">
	</head>

<body>
	<header>
		<?php include('header.php'); ?>
	</header>
	
	<div class="formContent">
		<h2>Login</h2>
		<?php
			$username = '';
			$password = '';
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				if (!empty($_POST['username']))
				{
					$username = $_POST['username'];
				}
				
				if (!empty($_POST['password']))
				{
					$password = SHA1($_POST['password']);
				}
			}
			
			/*$sql = mysqli_prepare($mysqlconn, "SELECT user_name, password, is_admin FROM users WHERE user_name = ? AND password = ?");
			mysqli_stmt_bind_param($sql, 'ss', $username, $password);
			
			mysqli_stmt_execute($sql);
			
			mysqli_stmt_bind_result($sql, $username, $password, $isadmin);
			
			mysqli_stmt_store_result($sql);
			
			if(mysqli_num_rows($sql) == 1) {
				session_start();
				
				$_SESSION = mysqli_fetch_array($sql);
				$isadmin = (int) $_SESSION['is_admin'];

				if($isadmin === 1)
				{
					header('Location:admin_pages/admin-page.php');
				}
				else
				{
					header('Location:member_page.php');
				}
			}*/
		
			$sql = "SELECT user_name, password, is_admin FROM users WHERE user_name = '$username' AND password = '$password'";
			$result = mysqli_query($mysqlconn, $sql);
			
			if(mysqli_num_rows($result) == 1)
			{
				session_start();
				
				$_SESSION = mysqli_fetch_array($result, MYSQLI_BOTH);
				$_SESSION['is_admin'] = (int) $_SESSION['is_admin'];
				if($_SESSION['is_admin'] === 1)
				{
					header('Location:admin_pages/admin-page.php');
				}
				else
				{
					header('Location:member_pages/member-page.php');
				}
			} 
		?>
		
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			<div class="field">
				<label>Username: <label>
				<input type="text" name="username">
			</div>
			<div class="field">
				<label>Password: <label>
				<input type="password" name="password">
				<br>
				&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Between 8 and 12 characters
			</div>
			<input type="submit" name="submit" value="Login" style="margin-bottom:2%;">
		</form>
	</div>
	
	<footer>
		<?php include('footer.php'); ?>
	</footer>
</body>


</html>
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
				<?php include('../nav/admin/admin-manage-users-nav.php');?>
			</div>
			
			<div class="col-9 content formContent">
				<?php include('../logged-in-as.php'); ?>
				<?php $id = $_GET['id'];?>
				<?php		
					if ($_SERVER['REQUEST_METHOD'] == 'POST')
					{
						$userName = $_POST['username'];
						$firstName = $_POST['firstname'];
						$lastName = $_POST['lastname'];
						$email = $_POST['emailaddress'];
						$password = SHA1($_POST['password']);
						if(isset($_POST['isadmin']))
						{
							$isAdmin = 1;
						}
						else
						{
							$isAdmin = 0;
						}
					
						$query = "UPDATE users
									SET user_name = ?, 
										first_name = ?, 
										last_name = ?, 
										email = ?, 
										password = ?, 
										is_admin = ?
									WHERE user_id = ?";
						
						$preparedStmt = @mysqli_prepare($mysqlconn, $query);
						if (@mysqli_stmt_bind_param($preparedStmt, 
													"sssssii", 
													$userName, 
													$firstName, 
													$lastName,
													$email,													
													$password, 
													$isAdmin,
													$id) &&
							@mysqli_stmt_execute($preparedStmt))
						{
							@mysqli_stmt_close($preparedStmt); 
							header("Location: admin-manage-users.php");
						} 
						else
						{
							$query = "UPDATE users
										SET user_name = '$userName', 
											first_name = '$firstName', 
											last_name = '$lastName', 
											email = '$email', 
											password = '$password', 
											is_admin = '$isAdmin'
										WHERE user_id = '$id'";
							echo '<p class="error">This page has been accessed in error.</p>';
							echo "<p>" . @mysqli_error($mysqlconn) . "<br><br/>Query: " . $query . "</p>";                            
						}                      
					}
					
					$query = "SELECT user_name, first_name, last_name, email, is_admin
							FROM users
							WHERE user_id = ?";
									
					$preparedStmt = @mysqli_prepare($mysqlconn, $query);
					if (@mysqli_stmt_bind_param($preparedStmt, "i", $id)    && 
						@mysqli_stmt_execute($preparedStmt)                 &&
						@mysqli_stmt_bind_result($preparedStmt,
												 $userName,
												 $firstName,
												 $lastName,													
													$email,													
													$isAdmin
													))
					{
						@mysqli_stmt_fetch($preparedStmt);
						@mysqli_stmt_close($preparedStmt); 
						
						$password = '';
						
						echo '<h2>Edit User</h2><br>';
						echo '<form action="' . $_SERVER['PHP_SELF'] . '?id=' . $id . '" method="post">
								<div class="field">
									<label>User Name: </label>
										<input type="text" id="user-name" name="username"
										value="' . $userName . '" required>
								</div>
								
								<div class="field">	
									<label>First Name: </label>
										<input type="text" id="first-name" name="firstname"
										value="' . $firstName . '" required>
								</div>
								
								<div class="field">
									<label>Last Name: </label>
										<input type="text" id="last-name" name="lastname"
										value="' . $lastName . '" required>
								</div>
								
								<div class="field">
									<label>Email Address: </label>
										<input type="text" id="email-address" name="emailaddress"
										value="' . $email . '"  required>
								</div>
								
								<div class="field">
									<label>Password: </label>
										<input type="password" id="password" name="password"
										value="' . $password . '"  required>
								</div>
								';
								
								if($isAdmin == 1)
								{ 
									echo '
									<div class="field">
										<label>Is Admin </label>
										<input type="checkbox" id="isadmin" name="isadmin" 
										value="' . $isAdmin . '" checked>
									</div>
									';
								}
								if($isAdmin == 0)
								{
									echo '
									<div class="field">
										<label>Is Admin </label>
										<input type="checkbox" id="isadmin" name="isadmin" 
										value="' . $isAdmin . '" >
									</div>
									';
								}

								echo '
									<div class="field">
										<input type="submit" id="submit" name="submit"
											value="Edit">
									</div>
							</form>';                 
					}
					
					else 
					{ 
						$query = "SELECT user_name, first_name, last_name, email, is_admin
						FROM users
						WHERE user_id = '$id'";
							  
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
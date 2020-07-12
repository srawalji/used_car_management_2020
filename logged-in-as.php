<div class="login">
	<?php
		if(isset($_SESSION['user_name'])) {
			echo '<br><br>';
			echo 'You are currently logged in as: ' . $_SESSION['user_name'];
		}
	?>
</div>
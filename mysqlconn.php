<?php
	DEFINE ('DB_USER', 'webadmin');
	DEFINE ('DB_PASSWORD', 'webadmin');
	DEFINE ('DB_HOST', 'localhost');
	DEFINE ('DB_NAME', 'used_car_database');
	
	$mysqlconn = @mysqli_connect (DB_HOST, 
									 DB_USER, 
									 DB_PASSWORD, 
									 DB_NAME) OR
					die ('Could not connect to database: ' .mysqli_connect_error() );
	
	#mysql_set_charset($databaseconn, 'utf8');
						
?>
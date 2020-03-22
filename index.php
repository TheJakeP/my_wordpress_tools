<?php
	include("make_database.php");
	include("create_wordpress.php");
//phpinfo();

	$new_db_name = "coonley_law";

	$db_maker = new new_database();
	$db_maker->set_credentials('localhost', 'root', '');
	$db_exists = $db_maker->check_if_db_exists($new_db_name );


//		$db_maker->create_database(); 
//		$db_maker->drop_database();
//		$db_maker->drop_db_user($new_db_name );
		$db_maker->create_database();

	if ($db_exists) {
		echo "DB already exists<br>";
//		var_dump($db_maker->get_db_users());
//		$db_maker->drop_database();
	} else {
		echo "DB doesn't exist<br><b>Making Database!</b><br>";
		$db_maker->create_database();
	}
	$db_maker->close_connection();

?>
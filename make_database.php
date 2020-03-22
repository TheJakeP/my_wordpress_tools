<?php

class new_database {
	
	private $dbhost;
	private $dbuser;
	private $dbpass;
	private $dbname;
	
	private $mysqli;
	
	function __construct(){
	
	}
	
	function set_credentials ($host, $user, $pass) {
		$dbhost = $host;
		$dbuser = $user;
		$dbpass = $pass;
		$mysqli = mysqli_connect($dbhost, $dbuser, $dbpass);

		if (!$mysqli) {
			echo "Error: Unable to connect to MySQL." . PHP_EOL;
			echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
			echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
			exit;
		}
		$this->mysqli = $mysqli;
	}
	
	function check_if_db_exists($db_name){
		$this->database = $db_name;
		$db_selected = mysqli_select_db ($this->mysqli, $db_name);
		if ($db_selected) {
			return true;
		} else {
			return false;
		}
	}
	
	function create_database() { 
		$this->run_sql_query("CREATE DATABASE $this->database");
		echo "Created Database <b>$this->database</b><br>";
		$this->create_db_user($this->database, $this->random_password(12));
	}	
	function drop_database() {
		$this->run_sql_query("DROP DATABASE $this->database");
		echo "Dropped Database <b>$this->database</b><br>";
	}
	
	function create_db_user($username, $password) {
		echo "New DB User: <b>$username</b><br>";
		echo "New DB Pass: <b>$password</b><br>";

		$sql = "CREATE USER '$username'@'localhost' IDENTIFIED BY '$password'";
		$this->run_sql_query($sql);
		
		$sql = "GRANT ALL PRIVILEGES ON *.* TO '$username'@'localhost' REQUIRE NONE WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0";
		$this->run_sql_query($sql);
//		
//		$sql = "FLUSH PRIVILEGES";
//		$this->run_sql_query($sql);
	}
	
	function drop_db_user ($username){
		
		$this->run_sql_query("DROP $username");
	}
	
	function close_connection(){
		mysqli_close($this->mysqli);
	}
	
//	function get_db_users(){
////		$sql = $this->run_sql_query("SELECT * FROM mysql.db WHERE Db = '$this->dbname'");
//		$sql = $this->run_sql_query("SELECT * FROM mysql.db WHERE Db = 'dbnhw3rj3jf234'");
////		echo $sql;
//		echo $sql['dbnhw3rj3jf234'] . "<br><br>";
//		foreach ($sql as $key => $value){
//			echo "$key -> $value<br><br>";
//		}
////		var_dump(array_keys($sql['User']));
//	}
	
	private function run_sql_query ($sql_query){
		$mysqli = $this->mysqli;
		$result = $mysqli->query($sql_query);
		$row_cnt = @$result->num_rows;

    	printf("Result set has %d rows.\n", $row_cnt);
		if ($result === false) {
			echo "Dying";
			$this->close_connection();
			die("Could not execute query:<br>" . $mysqli->error);
		} else if ($row_cnt > 0){
			$result_arr = mysqli_fetch_array($result);
			return $result_arr;
		}
		return true;
	}
	
	private function random_password($pw_len) {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < $pw_len; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
   		return implode($pass); //turn the array into a string
	}
}

			?>

<!--
			
		$sql = 'SHOW DATABASES';

$result = $mysqli->query($sql);
if ($result === false) {
    throw new Exception("Could not execute query: " . $mysqli->error);
}

$db_names = array();
while($row = $result->fetch_array(MYSQLI_NUM)) { // for each row of the resultset
    $db_names[] = $row[0]; // Add db name to $db_names array
}

echo "Database names: " . PHP_EOL . print_r($db_names, TRUE); // display array
		
mysqli_close($mysqli);
	}
		

//		$conn = mysql_connect($dbhost, $dbuser, $dbpass);
//
//	
//   if(! $conn ) {
//      die('Could not connect: ' . mysql_error());
//   }
//   
//   echo 'Connected successfully';
//   
//   $sql = 'CREATE Database test_db';
//   $retval = mysql_query( $sql, $conn );
//   
//   if(! $retval ) {
//      die('Could not create database: ' . mysql_error());
//   }
//   
//   echo "Database test_db created successfully\n";
//   mysql_close($conn);
//	}
}
?>-->

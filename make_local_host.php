<?php
//	include("make_database.php");
	include("create_wordpress.php");
	
//	new wordpress_install("test_theme");

$url = 'http://localhost/add_vhost.php';
//$url = 'post_tester.php';



$vh_name = "this_is_not_a_test";
$vh_folder = 'C:\wp_sites\\';
$vh_ip = "";
$passadd = mt_rand(100000001,mt_getrandmax());
$vars = "vh_name=$vh_name&vh_folder=$vh_folder&passadd=$passadd";

$vars_arr = array(
	'vh_name' => $vh_name,
	'vh_folder' => $vh_folder,
	'passadd' => $passadd,
	'submit' => 'Start the creation of the VirtualHost (May take a while...)'
	);

$v = http_build_query($vars_arr);
//echo $v;
//return;

if (strlen($vh_ip) > 0) {
	$vars.= "&vh_ip=$vh_ip";
}

echo exec("echo 127.0.0.1	$vh_name >> %WINDIR%\System32\Drivers\Etc\Hosts");
echo exec("echo ::1	$vh_name >> %WINDIR%\System32\Drivers\Etc\Hosts");

$add_host = "#
<VirtualHost *:80>
	ServerName $vh_name
	DocumentRoot \"$vh_folder\"
	<Directory  \"$vh_folder\">
		Options +Indexes +Includes +FollowSymLinks +MultiViews
		AllowOverride All
		Require local
	</Directory>
</VirtualHost>";

$fp = fopen('C:\wamp64\bin\apache\apache2.4.41\conf\extra\httpd-vhosts.conf', 'a');//opens file in append mode  
fwrite($fp, $add_host);  
fclose($fp);


//
//$ch = curl_init();
//
//curl_setopt($ch, CURLOPT_URL,$url);
//curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_POSTFIELDS, $v);
//
//// In real life you should use something like:
//// curl_setopt($ch, CURLOPT_POSTFIELDS, 
////          http_build_query(array('postvar1' => 'value1')));
//
//// Receive server response ...
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//$server_output = curl_exec($ch);
//var_dump($server_output);
//curl_close ($ch);

// Further processing ...
//if ($server_output == "OK") { ... } else { ... }

//$ch = curl_init( $url );
//curl_setopt( $ch, CURLOPT_POST, 1);
//curl_setopt( $ch, CURLOPT_POSTFIELDS, $vars);
//curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
//curl_setopt( $ch, CURLOPT_HEADER, 0);
//curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt ($ch, CURLOPT_COOKIEJAR, COOKIE_FILE); 
//curl_setopt ($ch, CURLOPT_COOKIEFILE, COOKIE_FILE); 
//
//$response = curl_exec( $ch );

//var_dump($response);
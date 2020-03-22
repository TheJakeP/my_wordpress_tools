<?php
	ob_start();

	echo '<pre>';
	$site_name = "" . DIRECTORY_SEPARATOR;
	$parent_dir = dirname( dirname(__FILE__) );
	$destination = $parent_dir. DIRECTORY_SEPARATOR . $site_name;


	$wp_zip_name = "WordPress_Core.zip";
	if (!file_exists( "../$wp_zip_name")) {
		// Download file
		echo '<span style="color:blue">DOWNLOADING...</span><br>'.PHP_EOL;

		echo "WordPress_Core.zip Not Found<br>Downlading Latest from Wordpress.org/latest.zip<br>";
		ob_flush();
		file_put_contents("../$wp_zip_name", file_get_contents('http://wordpress.org/latest.zip'));
		echo "Download finished<br>";
		ob_flush();

	}

	echo "Extracting Zipped Files<br>";
	ob_flush();

	$zip = new ZipArchive();
	$res = $zip->open("../$wp_zip_name");
	if ($res === TRUE) {
		
		// Extract ZIP file
		$zip->extractTo($parent_dir);
		$zip->close();
		
	echo "Zip Extracted Successfully<br>";
	ob_flush();

		//		unlink($parent_dir . DIRECTORY_SEPARATOR . 'wp.zip');	//Delete File
		// Copy files from wordpress dir to current dir
		$source = "../wordpress/";

	echo "Renaming Folder<br>";
	ob_flush();

		rename('../wordpress', "../". $site_name);
		
	} else {
		echo "<br>Something went Wrong<br>";
	}


	ob_end_flush(); 
?>
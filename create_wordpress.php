<?php


class wordpress_install {

	private $site_name;
	private $parent_dir;
	
	function __construct($site_name){
		$this->site_name = $site_name;
		$this->__setup_wordpress($site_name);
	}

	private function __setup_wordpress($site_name){
		$this->parent_dir = dirname( dirname(__FILE__) );
		
		$wp_zip_name = "WordPress_Core.zip";
		if (!file_exists( "../$wp_zip_name")) {
			$this->__download_wordpress_core($wp_zip_name);
			echo "downloaded new zip";
		}
		$this->__unzip_wordpress_core($wp_zip_name);
		$rename_successful = rename('../wordpress', "../". $this->site_name);
		if (!$rename_successful){
			$src = "../wordpress";
			$dst = "../" . $this->site_name;
			$this->recurse_copy($src, $dst);
			unlink($source);
		}
		$this->__copy_wp_files();
		
	}
	
	private function recurse_copy($src,$dst) { 
		$dir = opendir($src); 
		@mkdir($dst); 
		while(false !== ( $file = readdir($dir)) ) { 
			if (( $file != '.' ) && ( $file != '..' )) { 
				if ( is_dir($src . '/' . $file) ) { 
					$this->recurse_copy($src . '/' . $file,$dst . '/' . $file); 
				} 
				else { 
					copy($src . '/' . $file,$dst . '/' . $file); 
				} 
			} 
		} 
		closedir($dir); 
	} 
	
	private function __copy_wp_files(){
		$source = "resources";
		$dest = "../" . $this->site_name;
		$this->recurse_copy($source, $dest);
	}
	
	private function __download_wordpress_core($wp_zip_name){
		file_put_contents("../$wp_zip_name", file_get_contents('http://wordpress.org/latest.zip'));
	}
	
	private function __unzip_wordpress_core($wp_zip_name){
		$zip = new ZipArchive();
		$res = $zip->open("../$wp_zip_name");
		
		if ($res === TRUE) {
			// Extract ZIP file
			$zip->extractTo($this->parent_dir);
			$zip->close();
		} else {
			echo "<br>Something went Wrong<br>";
		}
	}
}




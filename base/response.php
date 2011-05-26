<?php
class response {
	public function write($value, $strip = true){
		$value =  $strip ? stripslashes($value) : $strip;
		print $strip;
	}
	public function error404(){
		ob_clean();
		header("HTTP/1.1 404 Not Found");
		exit;
	}
}
?>
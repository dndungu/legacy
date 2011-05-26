<?php
function userTokenCreate($token){
	$result = database::query(sprintf("UPDATE `user` SET `token` = '%s', `updateTime` = %d WHERE `email` = '%s' LIMIT 1", $token, time(), database::sanitize(request::read('email'))));
	global $db_link;
	return $result ? mysqli_affected_rows($db_link) : false;
}
function createToken($size=40) {
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz023456789";
	srand((double)microtime()*1000000);
	$output = '';
	while($size){
		$num = rand() % 59; 
		$output .= substr($chars, $num, 1);
		$size--;
	}
	return $output;
}
?>
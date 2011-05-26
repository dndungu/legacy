<?php
function userRead(){
	$username = database::sanitize(request::read("username"));
	$result = database::query(sprintf("SELECT * FROM `user` WHERE (`email` = '%s' OR `username` = '%s') AND `password` = '%s' LIMIT 1", $username, $username, md5(database::sanitize(request::read("password")))));
	if($result && $result->num_rows){
		return $result->fetch_assoc();
	} else {
		return false;
	}
}
?>
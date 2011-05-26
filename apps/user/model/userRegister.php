<?php
function userRegister(){
	$result = database::query(sprintf("INSERT INTO `user` (`email`, `username`, `password`, `creationTime`) VALUES('%s', '%s', '%s', %d)", database::sanitize(request::read('email')), database::sanitize(request::read('username')), md5(database::sanitize(request::read('password'))), time()));
	global $db_link;
	return $result ? mysqli_insert_id($db_link) : false;
}
?>
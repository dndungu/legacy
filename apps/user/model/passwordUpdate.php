<?php
function passwordUpdate(){
	$result = database::query(sprintf("UPDATE `user` SET `updateTime` = %d, `password` = '%s' WHERE `email` = '%s' AND `token` = '%s' LIMIT 1", time(), md5(database::sanitize(request::read("password"))), database::sanitize(request::read("email")), database::sanitize(request::read("token"))));
	global $db_link;
	return $result ? mysqli_affected_rows($db_link) : false;
}
?>
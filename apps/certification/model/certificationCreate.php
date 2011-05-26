<?php
function certificationCreate($author){
	$result = database::query(sprintf("INSERT INTO `certification` (`name`, `creationTime`, `updateTime`, `author`) VALUES('%s', %d, %d, %d)", database::sanitize(request::read('name')), time(), time(), $author));
	global $db_link;
	return $result ? mysqli_insert_id($db_link) : false;
}
?>
<?php
function technologyCreate($author){
	$result = database::query(sprintf("INSERT INTO `technology` (`acronym`, `fullname`, `notes`, `creationTime`, `updateTime`, `author`) VALUES('%s', '%s', '%s', %d, %d, %d)", database::sanitize(request::read('acronym')), database::sanitize(request::read('fullname')), database::sanitize(request::read('notes')), time(), time(), $author));
	global $db_link;
	return $result ? mysqli_insert_id($db_link) : false;
}
?>
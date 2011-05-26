<?php
function widgetCreate($author){
	$result = database::query("SELECT `ID` FROM `widget` ORDER BY `ID` LIMIT 1");
	$widget = $result && $result->num_rows ? $result->fetch_assoc() : array('ID' => 0);	
	$result = database::query(sprintf("INSERT INTO `widget` (`section`, `title`, `content`, `weight`, `creationTime`, `updateTime`, `author`) VALUES ('%s', '%s', '%s', %d, %d, %d, %d)", database::sanitize(request::read('section')), database::sanitize(request::read('title')), database::sanitize(request::read('content')), ++$widget['ID'], time(), time(), $author));
	global $db_link;
	return $result ? mysqli_insert_id($db_link) : false;
}
?>
<?php
function aspectCreate($author){
	$result = database::query(sprintf("INSERT INTO `aspect` (`title`, `width`, `height`, `creationTime`, `updateTime`, `author`) VALUES('%s', %d, %d, %d, %d, %d)", database::sanitize(request::read('title')), database::sanitize(request::read('width')), database::sanitize(request::read('height')), time(), time(), $author));
	global $db_link;
	return $result ? mysqli_insert_id($db_link) : false;
}
?>
<?php
function navigationCreate($author){
	$result = database::query(sprintf("INSERT INTO `navigation` (`uri`, `content`, `creationTime`, `updateTime`, `author`) VALUES('%s', '%s', %d, %d, %d)", database::sanitize(request::read('uri')), database::sanitize(request::read('content')), time(), time(), $author));
	global $db_link;
	return $result ? mysqli_insert_id($db_link) : false;
}
?>
<?php
function navigationUpdate($author){
	$result = database::query(sprintf("UPDATE `navigation` SET `uri` = '%s', `content` = '%s', `updateTime` = %d WHERE `ID` = %d AND `author` = %d LIMIT 1", database::sanitize(request::read('uri')), database::sanitize(request::read('content')), time(), database::sanitize(request::read('navigation')), $author));
	global $db_link;
	return $result ? mysqli_affected_rows($db_link) : false;
}
?>
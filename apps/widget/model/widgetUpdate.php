<?php
function widgetUpdate($author){
	$result = database::query(sprintf("UPDATE `widget` SET `section` = '%s', `title` = '%s', `content` = '%s', `updateTime` = %d WHERE `ID` = %d AND `author` = %d LIMIT 1", database::sanitize(request::read('section')), database::sanitize(request::read('title')), database::sanitize(request::read('content')), time(), database::sanitize(request::read('widget')), $author));
	global $db_link;
	return $result ? mysqli_affected_rows($db_link) : false;
}
?>
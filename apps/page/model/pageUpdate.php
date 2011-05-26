<?php
function pageUpdate($user){
	$result = database::query(sprintf("UPDATE `page` SET `title` = '%s', `content` = '%s', `description` = '%s', `updateTime` = %d, `published` = '%s' WHERE `ID` = %d AND `author` = %d",	database::sanitize(request::read("title")), database::sanitize(request::read("content")), database::sanitize(request::read("description")), time(), is_null(request::read("published")) ? "No" : database::sanitize(request::read("published")), database::sanitize(request::read('page')), $user));
	global $db_link;
	return $result ? mysqli_affected_rows($db_link) : false;
}
?>
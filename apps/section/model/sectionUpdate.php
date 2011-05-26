<?php
function sectionUpdate($author){
	$result = database::query(sprintf("UPDATE `section` SET `name` = '%s', `updateTime` = %d WHERE `ID` = %d AND `author` = %d LIMIT 1", database::sanitize(request::read('name')), time(), database::sanitize(request::read('section')), $author));
	global $db_link;
	return $result ? mysqli_affected_rows($db_link) : false;
}
?>
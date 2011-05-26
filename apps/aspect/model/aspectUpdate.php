<?php
function aspectUpdate($author){
	$result = database::query(sprintf("UPDATE `aspect` SET `title` = '%s', `width` = %d, `height` = %d, `updateTime` = %d WHERE `ID` = %d AND `author` = %d LIMIT 1", database::sanitize(request::read('title')), database::sanitize(request::read('width')), database::sanitize(request::read('height')), time(), database::sanitize(request::read('aspect')), $author));
	global $db_link;
	return $result ? mysqli_affected_rows($db_link) : false;
}
?>
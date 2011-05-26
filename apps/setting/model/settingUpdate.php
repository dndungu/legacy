<?php
function settingUpdate($author){
	$result = database::query(sprintf("UPDATE `setting` SET `value` = '%s', `updateTime` = %d WHERE `key` = '%s' AND `ID` = %d AND `author` = %d", database::sanitize(request::read('value')), time(), database::sanitize(request::read('key')), database::sanitize(request::read('setting')), $author));
	global $db_link;
	return $result ? mysqli_affected_rows($db_link) : false;
}
?>
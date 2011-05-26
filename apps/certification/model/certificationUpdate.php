<?php
function certificationUpdate($author){
	$result = database::query(sprintf("UPDATE `certification` SET `name` = '%s', `updateTime` = %d WHERE `ID` = %d AND `author` = %d LIMIT 1", database::sanitize(request::read('name')), time(), database::sanitize(request::read('certification')), $author));
	global $db_link;
	return $result ? mysqli_affected_rows($db_link) : false;
}
?>
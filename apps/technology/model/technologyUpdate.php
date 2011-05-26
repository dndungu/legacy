<?php
function technologyUpdate($author){
	$result = database::query(sprintf("UPDATE `technology` SET `acronym` = '%s', `fullname` = '%s', `notes` = '%s', `updateTime` = %d WHERE `ID` = %d AND `author` = %d LIMIT 1", database::sanitize(request::read('acronym')), database::sanitize(request::read('fullname')), database::sanitize(request::read('notes')), time(), database::sanitize(request::read('technology')), $author));
	global $db_link;
	return $result ? mysqli_affected_rows($db_link) : false;
}
?>
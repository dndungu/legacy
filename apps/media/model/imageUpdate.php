<?php
function imageUpdate($path, $ID){
	$result = database::query(sprintf("UPDATE `image` SET `path` = '%s' WHERE `ID` = %d LIMIT 1", database::sanitize($path), $ID));
	global $db_link;
	return $result ? mysqli_affected_rows($db_link) : false;
}
?>
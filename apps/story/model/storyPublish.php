<?php
function storyPublish(){
	$result = database::query(sprintf("UPDATE `story` SET `published` = 'Yes' WHERE `ID` = %d", database::sanitize(request::read("story"))));
	global $db_link;
	return $result ? mysqli_insert_id($db_link) : false;
}
?>
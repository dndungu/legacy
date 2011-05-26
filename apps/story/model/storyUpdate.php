<?php
function storyUpdate($author){
	$result = database::query(sprintf("UPDATE `story` SET 
		`title` = '%s', 
		`teaser` = '%s', 
		`content` = '%s', 
		`section` = %d,
		`published` = '%s', 
		`updateTime` = %d
		WHERE `ID` = %d 
		AND `author` = %d
		LIMIT 1",
		database::sanitize(request::read("title")), 
		database::sanitize(request::read("teaser")), 
		database::sanitize(request::read("content")), 
		database::sanitize(request::read("section")),
		is_null(request::read("published")) ? "No" : database::sanitize(request::read("published")), 
		time(),
		database::sanitize(request::read("story")),
		$author));
	global $db_link;
	return $result ? mysqli_affected_rows($db_link) : false;
}
?>
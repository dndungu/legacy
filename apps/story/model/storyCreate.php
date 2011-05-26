<?php
function storyCreate($author){
	$title = database::sanitize(request::read("title"));
	$result = database::query(sprintf("INSERT INTO `story` (
		`uri`,
		`title`, 
		`teaser`, 
		`content`, 
		`author`, 
		`creationTime`, 
		`updateTime`, 
		`published`) VALUES (
		'%s',
		'%s', 
		'%s', 
		'%s', 
		%d, 
		%d, 
		%d, 
		'%s')", 
		strtolower(str_replace(' ','-',substr($title,0,32))),
		$title, 
		database::sanitize(request::read("teaser")), 
		database::sanitize(request::read("content")), 
		$author, 
		time(), 
		time(), 
		is_null(request::read("published")) ? "No" : database::sanitize(request::read("published"))
	));
	global $db_link;
	return $result ? mysqli_insert_id($db_link) : false;
}
?>
<?php
function pageCreate($user){
	global $db_link;
	$title = database::sanitize(request::read("title"));
	$parent = database::sanitize(request::read("parent"));
	$parent = is_null($parent) ? 0 : $parent;
	$result = database::query("SELECT `ID` FROM `page` ORDER BY `ID` DESC LIMIT 1");
	$page = $result && $result->num_rows ? $result->fetch_assoc() : array('ID' => 0);
	$result = database::query(sprintf("INSERT INTO `page` (`uri`, `parent`, `title`, `content`, `description`, `author`, `creationTime`, `updateTime`, `published`, `weight`) VALUES('%s', %d, '%s', '%s', '%s', %d, %d, %d, '%s', %d)", strtolower(str_replace(' ','-',substr($title,0,32))), $parent, database::sanitize(request::read("title")), database::sanitize(request::read("content")), database::sanitize(request::read("description")), $user, time(), time(), is_null(request::read("published")) ? "No" : database::sanitize(request::read("published")), ++$page['ID']));
	return $result ? mysqli_insert_id($db_link) : false;
}
?>
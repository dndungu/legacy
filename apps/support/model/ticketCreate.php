<?php
function ticketCreate($user){
	$result = database::query(sprintf("INSERT INTO `ticket` (`user`, `subject`, `content`, `creationTime`) VALUES (%d, '%s', '%s', %d)", $user, database::sanitize(request::read("subject")), database::sanitize(request::read("content")), time()));
	global $db_link;
	return $result ? mysqli_insert_id($db_link) : false;
}
?>
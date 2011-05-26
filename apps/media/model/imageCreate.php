<?php
function imageCreateRecord($title, $width, $height){
	$result = database::query(sprintf("INSERT INTO `image` (`title`, `width`, `height`, `creationTime`, `updateTime`) VALUES('%s', %d, %d, %d, %d)", $title, $width, $height, time(), time()));
	global $db_link;
	return $result ? mysqli_insert_id($db_link) : false;
}
?>
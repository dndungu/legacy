<?php
function imageAspectCreate($image, $aspect, $path){
	$result = database::query(sprintf("INSERT INTO `image_aspect` (`image`, `aspect`, `path`, `creationTime`) VALUES(%d, %d, '%s', %d)", $image, $aspect, $path, time()));
	global $db_link;
	return $result ? mysqli_insert_id($db_link) : false;
}
?>
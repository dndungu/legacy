<?php
function bannerCreate($author){
	$expireTime = explode("/", request::read('expireTime'));
	$month = isset($expireTime[0]) ? intval($expireTime[0]) : 8;
	$day = isset($expireTime[1]) ? intval($expireTime[1]) : 2;
	$year = isset($expireTime[2]) ? intval($expireTime[2]) : 1980;
	$expireTime = mktime(8,0,0,$month,$day,$year);
	$result = database::query(sprintf("INSERT INTO `banner` (`story`, `heading`, `image`, `expireTime`, creationTime`, `updateTime`, `author`) VALUES (%d, '%s', %d, %d, %d, %d, %d)", database::sanitize(request::read('story')), database::sanitize(request::read('heading')), database::sanitize(request::read('image')), $expireTime, time(), time(), $author));
	global $db_link;
	return $result ? mysqli_insert_id($db_link) : false;
}
?>
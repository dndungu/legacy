<?php
function bannerUpdate($author){
	$expireTime = explode("/", request::read('expireTime'));
	$month = isset($expireTime[0]) ? intval($expireTime[0]) : 8;
	$day = isset($expireTime[1]) ? intval($expireTime[1]) : 2;
	$year = isset($expireTime[2]) ? intval($expireTime[2]) : 1980;
	$expireTime = mktime(8,0,0,$month,$day,$year);
	$result = database::query(sprintf("UPDATE `banner` SET `story` = %d, `heading` = '%s', `image` = %d, `expireTime` = %d, `updateTime` = %d WHERE `author` = %d AND `ID` = %d", database::sanitize(request::read('story')), database::sanitize(request::read('heading')), database::sanitize(request::read('image')), $expireTime, time(), $author, database::sanitize(request::read('banner'))));
	global $db_link;
	return $result ? mysqli_affected_rows($db_link) : false;
}
?>
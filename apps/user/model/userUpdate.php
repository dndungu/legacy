<?php
function userUpdate($author=0){
	$dob = explode("/", request::read('dob'));
	$month = isset($dob[0]) ? intval($dob[0]) : 8;
	$day = isset($dob[1]) ? intval($dob[1]) : 2;
	$year = isset($dob[2]) ? intval($dob[2]) : 1980;
	$result = database::query(sprintf("UPDATE `user` SET 
		`email` = '%s', 
		`firstName` = '%s', 
		`lastName` = '%s', 
		`about` = '%s', 
		`gender` = '%s', 
		`DOB` = %d, 
		`address` = '%s', 
		`phone` = '%s', 
		`website` = '%s', 
		`notice` = %d, 
		`fulltime` = '%s', 
		`freelancer` = '%s',
		`updateTime` = %d
		 WHERE `ID` = %d LIMIT 1",
		database::sanitize(request::read('email')), 
		database::sanitize(request::read('firstName')), 
		database::sanitize(request::read('lastName')), 
		database::sanitize(request::read('about')), 
		database::sanitize(request::read('gender')), 
		mktime(8,0,0,$month,$day,$year), 
		database::sanitize(request::read('address')), 
		database::sanitize(request::read('phone')), 
		database::sanitize(request::read('website')), 
		database::sanitize(request::read('notice')), 
		database::sanitize(request::read('fulltime')), 
		database::sanitize(request::read('freelancer')),
		time(), 
		$author));
	global $db_link;
	return $result ? mysqli_affected_rows($db_link) : false;
}
?>
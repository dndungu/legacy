<?php
function userCreate(){
	$result = database::query(sprintf("INSERT INTO `user` (
		`email`, 
		`firstName`, 
		`lastName`, 
		`about`, 
		`gender`, 
		`DOB`, 
		`address`, 
		`phone`, 
		`website`, 
		`notice`, 
		`fulltime`,
		`freelancer`, 
		`creationTime`) VALUES (
		'%s', 
		'%s', 
		'%s', 
		'%s', 
		'%s', 
		%d, 
		'%s', 
		'%s', 
		'%s', 
		%d, 
		'%s', 
		'%s', 
		%d, 
		%d)", 
		database::sanitize(request::read("email")), 
		database::sanitize(request::read("firstName")), 
		database::sanitize(request::read("lastName")), 
		database::sanitize(request::read("about")), 
		database::sanitize(request::read("gender")), 
		database::sanitize(request::read("DOB")), 
		database::sanitize(request::read("address")), 
		database::sanitize(request::read("phone")), 
		database::sanitize(request::read("website")), 
		database::sanitize(request::read("notice")), 
		is_null(request::read("fulltime")) ? "No" : database::sanitize(request::read("fulltime")), 
		is_null(request::read("freelancer")) ? "No" : database::sanitize(request::read("freelancer")), 
		database::sanitize(request::read("email")), 
		time()));
	global $db_link;
	return $result ? mysqli_insert_id($db_link) : false;
}
?>
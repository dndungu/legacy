<?php
function educationCreate($user){
	$start = explode("/", request::read('start'));
	$month = isset($start[0]) ? intval($start[0]) : 8;
	$day = isset($start[1]) ? intval($start[1]) : 2;
	$year = isset($start[2]) ? intval($start[2]) : 1980;
	$start = mktime(8,0,0,$month,$day,$year);
	$completion = explode("/", request::read('completion'));
	$month = isset($completion[0]) ? intval($completion[0]) : 8;
	$day = isset($completion[1]) ? intval($completion[1]) : 2;
	$year = isset($completion[2]) ? intval($completion[2]) : 1980;
	$completion = mktime(17,0,0,$month,$day,$year);
	$result = database::query(sprintf("INSERT INTO `education` (`user`, `institution`, `certification`, `program`, `start`, `completion`, `grade`, `notes`, `creationTime`) VALUES(%d, '%s', '%s', '%s', %d, %d, '%s', '%s', %d)", $user, database::sanitize(request::read('institution')), database::sanitize(request::read('certification')), database::sanitize(request::read('program')), $start, $completion, database::sanitize(request::read('grade')), database::sanitize(request::read('notes')), time()));
	return $result ? true : false;
}
?>
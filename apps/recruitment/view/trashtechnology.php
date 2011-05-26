<?php
function trashtechnology($base){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		database::trash('experience_technology', database::sanitize(request::read('experience_technology')));
		print '{}';
		return true;
	} else {
		return false;
	}
}
?>
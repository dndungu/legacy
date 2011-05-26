<?php
function get($base){
	header("Content-type: text/json");
	if(security::enforce('normal') or security::enforce('super')){
		require_once("$base/apps/education/model/educationRead.php");
		print json_encode(database::json(educationRead(session::read('user'))));
	} else {
		session::write('redirect', '/recruitment');
		print '{"redirect": "/user/login"}';
	}
	return true;
}
?>
<?php
function post($base){
	header("Content-type: text/json");
	if(security::enforce('normal')){
		require_once("$base/apps/education/model/educationCreate.php");
		if(educationCreate(session::read("user"))){
			print '{"success": "Education saved."}';
		} else {
			print '{"error": "There were problems persisting your changes."}';
		}
	} else {
		session::write('redirect', '/recruitment');
		print '{"redirect": "/user/login"}';
	}
	return true;
}
?>
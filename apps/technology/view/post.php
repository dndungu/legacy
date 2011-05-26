<?php
function post($base){
	if(security::enforce("super")){
		header("Content-type: application/json");
		if(intval(request::read("technology")) > 0){
			require_once("$base/apps/technology/model/technologyUpdate.php");
			if(technologyUpdate(session::read('user'))){
				print '{"redirect": "technology.refresh"}';
			} else {
				print '{"error": "Yikes update failed."}';
			}
		} else {
			require_once("$base/apps/technology/model/technologyCreate.php");
			if(technologyCreate(session::read('user'))){
				print '{"redirect": "technology.refresh"}';
			} else {
				print '{"error": "Yikes create failed."}';
			}
		}
	} else {
		session::write("redirect", "/panel");
		print '{"redirect": "/user/login"}';
	}
	return true;
}
?>
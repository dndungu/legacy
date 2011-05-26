<?php
function post($base){
	if(security::enforce("super")){
		header("Content-type: application/json");
		if(intval(request::read("navigation")) > 0){
			require_once("$base/apps/navigation/model/navigationUpdate.php");
			if(navigationUpdate(session::read('user'))){
				print '{"redirect": "navigation.refresh"}';
			} else {
				print '{"error": "Yikes update failed."}';
			}
		} else {
			require_once("$base/apps/navigation/model/navigationCreate.php");
			if(navigationCreate(session::read('user'))){
				print '{"redirect": "navigation.refresh"}';
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
<?php
function post($base){
	if(security::enforce("super")){
		header("Content-type: application/json");
		if(intval(request::read("aspect")) > 0){
			require_once("$base/apps/aspect/model/aspectUpdate.php");
			if(aspectUpdate(session::read('user'))){
				print '{"redirect": "aspect.refresh"}';
			} else {
				print '{"error": "Yikes update failed."}';
			}
		} else {
			require_once("$base/apps/aspect/model/aspectCreate.php");
			if(aspectCreate(session::read('user'))){
				print '{"redirect": "aspect.refresh"}';
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
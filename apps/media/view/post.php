<?php
function post($base){
	if(security::enforce("super")){
		header("Content-type: application/json");
		if(intval(request::read("image")) > 0){
			require_once("$base/apps/media/model/imageUpdate.php");
			if(imageUpdate(session::read('user'))){
				print '{"redirect": "image.refresh"}';
			} else {
				print '{"error": "Yikes update failed."}';
			}
		} else {
			require_once("$base/apps/media/model/imageCreate.php");
			if(imageCreate(session::read('user'))){
				print '{"redirect": "image.refresh"}';
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
<?php
function post($base){
	if(security::enforce("super")){
		header("Content-type: application/json");
		if(intval(request::read("certification")) > 0){
			require_once("$base/apps/certification/model/certificationUpdate.php");
			if(certificationUpdate(session::read('user'))){
				print '{"redirect": "certification.refresh"}';
			} else {
				print '{"error": "Yikes update failed."}';
			}
		} else {
			require_once("$base/apps/certification/model/certificationCreate.php");
			if(certificationCreate(session::read('user'))){
				print '{"redirect": "certification.refresh"}';
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
<?php
function post($base){
	if(security::enforce("super")){
		header("Content-type: application/json");
		if(intval(request::read("section")) > 0){
			require_once("$base/apps/section/model/sectionUpdate.php");
			if(sectionUpdate(session::read('user'))){
				print '{"redirect": "section.refresh"}';
			} else {
				print '{"error": "Yikes update failed."}';
			}
		} else {
			require_once("$base/apps/section/model/sectionCreate.php");
			if(sectionCreate(session::read('user'))){
				print '{"redirect": "section.refresh"}';
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
<?php
function post($base){
	if(security::enforce("super")){
		header("Content-type: application/json");
		if(intval(request::read("page")) > 0){
			require_once("$base/apps/page/model/pageUpdate.php");
			if(pageUpdate(session::read('user'))){
				print '{"redirect": "page.refresh"}';
			} else {
				print '{"error": "Yikes"}';
			}
		} else {
			require_once("$base/apps/page/model/pageCreate.php");
			if(pageCreate(session::read('user'))){
				print '{"redirect": "page.refresh"}';
			} else {
				print '{"error": "Yikes"}';
			}
		}
	} else {
		session::write("redirect", "/panel");
		print '{"redirect": "/user/login"}';
	}
	return true;
}
?>
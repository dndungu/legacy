<?php
function post($base){
	if(security::enforce("super")){
		header("Content-type: application/json");
		if(intval(request::read("banner")) > 0){
			require_once("$base/apps/banner/model/bannerUpdate.php");
			if(bannerUpdate(session::read('user'))){
				print '{"redirect": "banner.refresh"}';
			} else {
				print '{"error": "Yikes update failed."}';
			}
		} else {
			require_once("$base/apps/banner/model/bannerCreate.php");
			if(bannerCreate(session::read('user'))){
				print '{"redirect": "banner.refresh"}';
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
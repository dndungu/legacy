<?php
function post($base){
	if(security::enforce("super")){
		header("Content-type: application/json");
		if(intval(request::read("setting")) > 0){
			require_once("$base/apps/setting/model/settingUpdate.php");
			if(settingUpdate(session::read('user'))){
				print '{"redirect": "setting.refresh"}';
			} else {
				print '{"error": "Yikes update failed."}';
			}
		} else {
			require_once("$base/apps/setting/model/settingCreate.php");
			if(settingCreate(session::read('user'))){
				print '{"redirect": "setting.refresh"}';
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
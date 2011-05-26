<?php
function post($base){
	if(security::enforce("super")){
		header("Content-type: application/json");
		if(intval(request::read("widget")) > 0){
			require_once("$base/apps/widget/model/widgetUpdate.php");
			if(widgetUpdate(session::read('user'))){
				print '{"redirect": "widget.refresh"}';
			} else {
				print '{"error": "Yikes update failed."}';
			}
		} else {
			require_once("$base/apps/widget/model/widgetCreate.php");
			if(widgetCreate(session::read('user'))){
				print '{"redirect": "widget.refresh"}';
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
<?php
function post($base){
	if(security::enforce("super")){
		header("Content-type: application/json");
		if(intval(request::read("story")) > 0){
			require_once("$base/apps/story/model/storyUpdate.php");
			if(storyUpdate(session::read('user'))){
				print '{"redirect": "story.refresh"}';
			} else {
				print '{"error": "Yikes"}';
			}
		} else {
			require_once("$base/apps/story/model/storyCreate.php");
			if(storyCreate(session::read('user'))){
				print '{"redirect": "story.refresh"}';
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
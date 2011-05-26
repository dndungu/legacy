<?php
function post($base){
	require_once("$base/apps/user/model/userUpdate.php");
	if(userUpdate(session::read('user'))){
		echo '{"status": "success"}';
	} else {
		echo '{"status": "failure"}';
	}
	return true;
}
?>
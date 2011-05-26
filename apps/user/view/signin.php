<?php
function signin($base){
	header("Content-type: text/json");
	require("$base/apps/user/model/userRead.php");
	$user = userRead();
	if($user){
		$redirect = session::read('redirect');
		$redirect = is_null($redirect) ? '/' : $redirect;
		session::write("clearance", $user['clearance']);
		session::write("user", $user['ID']);
		print '{"redirect": "'.$redirect.'"}';
	} else {
		print '{"error": "Sorry, the username and password are not correct."}';
	}
	return true;
}
?>
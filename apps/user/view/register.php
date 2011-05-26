<?php
function register($base){
	header("Content-type: text/json");
	require_once("$base/apps/user/model/emailExists.php");
	if(emailExists()){
		print '{"error": "E-mail is already in use in our system."}';
	} else {
		require_once("$base/apps/user/model/usernameExists.php");
		if(usernameExists()){
			print '{"error": "Username is already in use in our system."}';
		} else {
			require_once("$base/apps/user/model/isEmail.php");
			if(isEmail(request::read('email'))){
				if(strlen(request::read('username')) > 7 && strlen(request::read('password')) > 7){
					if(request::read('password') == request::read('confirm')){
						require_once("$base/apps/user/model/userRegister.php");
						$user = userRegister();
						if($user){
							$redirect = session::read('redirect');
							$redirect = is_null($redirect) ? '/' : $redirect;
							session::write('user', $user);
							session::write('clearance', 'normal');
							print '{"redirect": "'.$redirect.'"}';
						} else {
							print '{"error": "Yikes"}';
						}
					} else {
						print '{"error": "Your passwords do not match."}';
					}
				} else {
					print '{"error": "Please enter a username and password longer than seven characters."}';
				}
			} else {
				print '{"error": "Please enter a valid email address."}';
			}
		}
	}
	return true;
}
?>
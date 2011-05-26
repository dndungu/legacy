<?php
function change($base){
	header("Content-type: text/json");
	require_once("$base/apps/user/model/tokenRead.php");
	$password = request::read('password');
	if(strlen($password) > 7){
		if(tokenRead()){
			
			$confirm = request::read('confirm');
			if($password == $confirm){
				require_once("$base/apps/user/model/passwordUpdate.php");
				if(passwordUpdate()){
					require_once("$base/apps/user/model/userEmail.php");
					$password = request::read('password');
					if(userEmail(request::read('email'), "Password Updated", "Hi,\rYour password has been changed to $password\r--------------------------\rthanks \r Support team.")){
						print '{"open": "signin", "info": "Your password has been updated and sent to your email address. You can login to proceed."}';
					} else {
						print '{"error", "Your password was changed but there was difficulty sending it to your email."}';
					}
				} else {
					print '{"error": "Yikes"}';
				}
			} else {
				print '{"error": "Your passwords do not match."}';
			}
		} else {
			print '{"error": "Please enter a valid password recovery token or request a new one."}';
		}	
	} else {
		print '{"error": "Please enter a password with eight or more characters."}';
	}
	return true;
}
?>
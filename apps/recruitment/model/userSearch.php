<?php
function userSearch(){
	$result = database::query(sprintf("SELECT * FROM `user` WHERE `ID` IN (SELECT `user` FROM `experience_technology` WHERE `technology` IN (SELECT `ID` FROM `technology` WHERE MATCH(`fullname`) AGAINST('%s')))", database::sanitize(request::read('keywords'))));
	if($result && $result->num_rows){
		while($user = $result->fetch_assoc()){
			$users[] = $user;
		}
		return $users;
	} else {
		return false;
	}
}
?>
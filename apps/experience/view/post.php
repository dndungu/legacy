<?php
function post($base){
	header("Content-type: text/json");
	if(security::enforce('normal')){
		$experience = intval(request::read('experience'));
		$user = session::read("user");
		if($experience > 0){
			require_once("$base/apps/experience/model/experienceTechnologyRead.php");
			$technologies = experienceTechnologyRead($experience);
			if(isset($_POST['technologies']) && is_array($_POST['technologies'])){
				global $db_link;
				foreach($_POST['technologies'] as $technology){
					if(!in_array($technology, $technologies)){
						$results[] = database::query(sprintf("INSERT INTO `experience_technology` (`user`, `experience`, `technology`, `creationTime`, `author`) VALUES(%d, %d, %d, %d, %d)",$user, $experience, database::sanitize($technology['technology']), time(), $user)) ? mysqli_insert_id($db_link) : false;
					}
				}
			}
			print isset($results) ? json_encode($results) : '[]';
		} else {
			require_once("$base/apps/experience/model/experienceCreate.php");
			$experience = experienceCreate(session::read("user"));
			if($experience){
				require_once("$base/apps/experience/model/experienceTechnologyCreate.php");
				$results = experienceTechnologyCreate($user, $experience);
				if($results){
					$output = array("success" => $results);
					print json_encode($results);
				} else {
					print '{"error": "There were problems persisting your changes."}';
				}
			} else {
				print '{"error": "There were problems persisting your changes."}';
			}
		}
	} else {
		session::write('redirect', '/recruitment');
		print '{"redirect": "/user/login"}';
	}
	return true;
}
?>
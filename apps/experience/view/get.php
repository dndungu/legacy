<?php
function get($base){
	header("Content-type: application/json");
	if(security::enforce('normal') or security::enforce('super')){
		require_once("$base/apps/experience/model/experienceRead.php");
		$experiences = experienceRead(session::read('user'));
		if($experiences){
			require_once("$base/apps/technology/model/technologyRead.php");
			$technologies = technologyRead(session::read('user'));
			if($technologies){
				foreach($experiences as $key => $experience){
					foreach($technologies as $technology){
						if($experience['ID'] == $technology['experience']){
							$experiences[$key]['technologies'][] = $technology;
						}
					}
				}
			}
		}
		print json_encode(database::json($experiences));
	} else {
		session::write('redirect', '/recruitment');
		print '{"redirect": "/user/login"}';
	}
	return true;
}
?>
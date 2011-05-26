<?php
function experienceTechnologyRead($experience){
	$result = database::query(sprintf("SELECT `experience_technology`.`ID`, `technology`, `fullname`, `experience` FROM `experience_technology` LEFT JOIN `technology` ON (`experience_technology`.`technology` = `technology`.`ID`) WHERE `experience` = %d AND `experience_technology`.`inTrash` = 'No' AND `experience_technology`.`author` = %d", $experience, session::read('user')));
	if($result && $result->num_rows){
		while($row = $result->fetch_assoc()){
			$rows[] = $row;
		}
		return $rows;
	} else {
		return false;
	}
}
?>
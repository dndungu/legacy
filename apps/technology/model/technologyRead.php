<?php
function technologyRead($author){
	$result = database::query(sprintf("SELECT `experience_technology`.`ID`, `technology`, `fullname`, `experience` FROM `experience_technology` LEFT JOIN `technology` ON (`experience_technology`.`technology` = `technology`.`ID`) WHERE `user` = %d AND `experience_technology`.`inTrash` = 'No'", $author));
	if($result && $result->num_rows){
		while($row = $result->fetch_assoc()){
			$rows[] =$row;
		}
		return $rows;
	} else {
		return false;
	}
}
?>
<?php
function experienceRead($user, $limit=10){
	$result = database::query(sprintf("SELECT * FROM `experience` WHERE `user` = %d AND `inTrash` = 'No' LIMIT %d", $user, $limit));
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
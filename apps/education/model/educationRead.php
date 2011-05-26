<?php
function educationRead($user, $limit=10){
	$result = database::query(sprintf("SELECT *, `name` FROM `education` LEFT JOIN `certification` ON (`education`.`certification` = `certification`.`ID`) WHERE `user` = %d LIMIT %d", $user, $limit));
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
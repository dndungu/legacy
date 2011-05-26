<?php
function userSearch($keywords, $limit=1){
	$result = database::query(sprintf("SELECT * FROM `user` WHERE `inTrash` = 'NO' MATCH(`email`, `username`, `firstName`, `lastName`, `about`, `gender`, `address`, `phone`, `website`) AGAINST('%s') LIMIT %d", $keywords, $limit));
	if($result && result->num_rows){
		while($user = $result->fetch_assoc()){
			$users[] = $user;
		}
		return $users;
	} else {
		return false;
	}
}
?>
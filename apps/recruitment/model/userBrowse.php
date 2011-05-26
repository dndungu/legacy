<?php
function userBrowse($pagesize){
	$page = is_null(request::read('recruitment')) ? 1 : intval(request::read('recruitment'));
	$start = ($page-1)*$pagesize;
	$result = database::query(sprintf("SELECT * FROM `user` WHERE `inTrash` = 'No' ORDER BY `ID` DESC LIMIT %d, %d", $start, $pagesize));
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
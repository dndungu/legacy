<?php
function search($base){
	header("Content-type: application/json");
	require_once("$base/apps/recruitment/model/userSearch.php");
	$users = userSearch();
	if($users){
		print json_encode(database::json($users));
	} else {
		print '[]';
	}
	return true;
}
?>
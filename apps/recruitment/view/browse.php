<?php
function browse($base){
	header("Content-type: application/json");
	$pagesize = 50;
	require_once("$base/apps/recruitment/model/userBrowse.php");
	require_once("$base/apps/recruitment/model/userCount.php");
	print json_encode(database::json(array("users"=> userBrowse($pagesize), "pages" => userCount($pagesize))));
	return true;
}
?>
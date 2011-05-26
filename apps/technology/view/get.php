<?php
function get($base){
	header("Content-type: application/json");
	require_once("$base/apps/technology/model/technologyRead.php");
	$technologies = technologyRead(session::read("user"));
	print json_encode(database::json($technologies ? $technologies : array()));
	return true;
}
?>
<?php
function browse($base){
	header("Content-type: application/json");
	print json_encode(database::json(database::read("page", 0, 100)));
	return true;
}
?>
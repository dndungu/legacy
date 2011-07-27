<?php
function browse($base){
	header("Content-type: application/json");
	print json_encode(database::json(array('count' => database::count("technology"), 'rows' => database::browse("technology"))));
	return true;
}
?>
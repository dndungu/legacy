<?php
function recycle($base){
	header("Content-type: application/json");
	print json_encode(database::json(database::read("setting",0,100,'Yes')));
	return true;
}
?>
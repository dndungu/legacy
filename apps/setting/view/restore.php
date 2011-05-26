<?php
function restore($base){
	header("Content-type: application/json");
	database::restore('setting', database::sanitize(request::read('setting')));
	print '{}';
	return true;
}
?>
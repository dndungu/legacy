<?php
function restore($base){
	header("Content-type: application/json");
	database::restore('aspect', database::sanitize(request::read('aspect')));
	print '{}';
	return true;
}
?>
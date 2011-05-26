<?php
function restore($base){
	header("Content-type: application/json");
	database::restore('story', database::sanitize(request::read('story')));
	print '{}';
	return true;
}
?>
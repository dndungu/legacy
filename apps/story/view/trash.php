<?php
function trash($base){
	header("Content-type: application/json");
	database::trash('story', database::sanitize(request::read('story')));
	print '{}';
	return true;
}
?>
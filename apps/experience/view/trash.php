<?php
function trash(){
	header("Content-type: application/json");
	database::trash('experience', database::sanitize(request::read('experience')));
	print '{}';
	return true;
}
?>
<?php
function trash(){
	header("Content-type: application/json");
	database::trash('page', database::sanitize(request::read('page')));
	print '{}';
	return true;
}
?>
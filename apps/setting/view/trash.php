<?php
function trash(){
	header("Content-type: application/json");
	database::trash('setting', database::sanitize(request::read('setting')));
	print '{}';
	return true;
}
?>
<?php
function get(){
	header("Content-type: application/json");
	$base = str_replace('/html', '', getcwd());
	require_once("$base/apps/banner/model/bannerRead.php");
	print json_encode(bannerRead(3, time()));
	return true;
}
?>
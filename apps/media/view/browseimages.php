<?php
function browseimages($base){
	header("Content-type: application/json");
	$page = is_null(request::read("media")) ? 1 : intval(request::read("media"));
	$pagesize = 50;
	$limit = ($page-1)*$pagesize;
	$result = database::query(sprintf("SELECT * FROM `image_aspect` WHERE `aspect` = 1 ORDER BY ID DESC LIMIT %d, %d", $limit, $pagesize));
	if($result && $result->num_rows){
		while($row = $result->fetch_assoc()){
			$rows[] = $row;
		}
		print json_encode(database::json($rows));
	} else {
		print '{}';
	}
	return true;
}
?>
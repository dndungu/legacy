<?php
function imagelistjs($base){
	header('Content-type: text/javascript');
	$js = 'var tinyMCEImageList = new Array(';
	$page = is_null(request::read("media")) ? 1 : intval(request::read("media"));
	$pagesize = 50;
	$limit = ($page-1)*$pagesize;
	$sql = sprintf("SELECT `title`, `image_aspect`.`path` FROM `image_aspect` LEFT JOIN `image` ON (`image_aspect`.`image` = `image`.`ID`) WHERE `aspect` = 1 ORDER BY `image_aspect`.`ID` DESC LIMIT %d, %d", $limit, $pagesize);
	$result = database::query($sql);
	$glue = "";
	if($result && $result->num_rows){
		while($row = $result->fetch_assoc()){
			$js .= $glue;
			$js .= '["'.$row['title'].'", "'.$row['path'].'"]';
			$glue = ",";
		}
	}
	$js .= ');';
	print $js;
	return true;
}
?>
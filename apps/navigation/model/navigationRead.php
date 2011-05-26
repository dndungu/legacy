<?php
function navigationRead(){
	$result = database::query("SELECT * FROM `navigation` WHERE `inTrash` = 'No' ORDER BY `weight`");
	if($result){
		while($row = $result->fetch_assoc()){
			$rows[] = $row;
		}
		return createTree($rows, 0);
	} else {
		return false;
	}
}
function createTree($rows, $parent){
	$tree = "";
	foreach($rows as $row){
		if($row['parent'] == $parent){
			$uri = $row['uri'];
			$content = $row['content'];
			$tree .= '<li><a href="'.$uri.'">'.$content.'</a></li>';
			$tree .= createTree($rows, $row['ID']);
		}
	}
	return strlen($tree) ? "<ul>$tree</ul>" : "";
}
?>
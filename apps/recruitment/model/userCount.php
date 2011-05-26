<?php
function userCount($pagesize){
	$result = database::query(sprintf("SELECT COUNT(`ID`) AS `count` FROM `user`"));
	$row = $result && $result->num_rows ? $result->fetch_assoc() : array('count' => 0);
	return ceil($row['count']/$pagesize);
}
?>
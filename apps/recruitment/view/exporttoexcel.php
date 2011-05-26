<?php
function exporttoexcel($base){
	try {
		$deny = security::enforce('super') ? false : true;
		if($deny) {throw new Exception("access denied");}
		$users = isset($_POST['users']) && count($_POST['users']) > 0 ? $_POST['users'] : false;
		if(!$users){throw new Exception("no users selected");}
		foreach($users as $user){
			$IDs[] = intval(database::sanitize(trim($user)));
		}
		$result = database::query(sprintf("SELECT `firstname`, `lastname`, `phone`, `email` FROM `user` WHERE ID IN (%s)", implode(", ", $IDs)));
		if($result && $result->num_rows){
			while($row = $result->fetch_assoc()){
				$rows[] = $row;
			}
		}else{
			throw new Exception("no applicants found");
		}
		header("Content-type: text/csv");
		header("Content-Disposition: attachment;filename=applicants.csv");
		function clean_text(&$value, $key){
			$value = str_replace(',', '\,', $value);
			$value = str_replace('&nbsp;', ' ', $value);
		}
		array_walk($rows, 'clean_text');
		print "FIRSTNAME,LASTNAME,PHONE,EMAIL\r";
		foreach($rows as $row){
			print trim(implode(",", $row));
			print "\r";
		}
	} catch(Exception $e) {
		header("Content-type: application/json");
		print '{"errors": "'.$e->getMessage().'"}';
	}
	return true;
}
?>

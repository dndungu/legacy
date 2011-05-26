<?php
function experienceTechnologyCreate($user, $experience){
	if(isset($_POST['technologies']) && is_array($_POST['technologies'])){
		global $db_link;
		foreach($_POST['technologies'] as $technology){
			$results[] = database::query(sprintf("INSERT INTO `experience_technology` (`user`, `experience`, `technology`, `creationTime`, `author`) VALUES(%d, %d, %d, %d, %d)",$user, $experience, database::sanitize($technology['technology']), time(), $user)) ? mysqli_insert_id($db_link) : false;
		}
		return $results;
	} else {
		return true;
	}
}
?>
<?php
class security {
	public function enforce($clearance){
		return session::read("clearance") === $clearance || session::read("clearance") === "super" ? true : false;
	}
}
?>
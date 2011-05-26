<?php
class session {
	public function start(){
		session_start();
		$_SESSION['fingerPrint'] = session::fingerPrint();
	}
	public function verify(){
		if(isset($_SESSION['fingerPrint']) and $_SESSION['fingerPrint'] === session::fingerPrint()){
			return true;
		} else {
			return false;
		}
	}
	public function fingerPrint(){
		$fingerPrint = '9gs6sk';
		$fingerPrint .= $_SERVER['HTTP_USER_AGENT'];
		$num_blocks = 4;
		$blocks = explode('.', isset($_SERVER['REMOTE_ADDR']) && strlen($_SERVER['REMOTE_ADDR']) === 15 ? $_SERVER['REMOTE_ADDR'] : "0.0.0.0");
		for ($i=0; $i < $num_blocks; $i++) {
			$fingerPrint .= $blocks[$i] . '.';
		}
		return md5($fingerPrint);		
	}
	public function write($key, $value){
		$_SESSION[$key] = $value;
	}
	public function read($key){
		if(isset($_SESSION[$key]) && session::verify()){
			return $_SESSION[$key];
		} else {
			return NULL;
		}
	}
	public function destroy(){
		$_SESSION = array();
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time() - 42000, '/');
		}
		session_destroy();
	}
}
session::start();
?>
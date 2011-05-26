<?php
class request{
	public function read($key){
		switch($_SERVER['REQUEST_METHOD']){
			case "GET":
				return request::getVar($key);
				break;
			case "POST":
				return request::postVar($key);
				break;
		}
	}
	public function getVar($key){
		if(isset($_GET[$key])){
			return trim($_GET[$key]);
		}else{
			return NULL;
		}
	}
	public function postVar($key){
		if(isset($_POST[$key])){
			return trim($_POST[$key]);
		}else{
			return NULL;
		}
	}
	public function getModule(){
		return isset($_GET['module']) ? trim(request::getVar('module')) : "home";
	}
	public function getView(){
		return isset($_GET['view']) ? trim(request::getVar('view')) : ($_SERVER['REQUEST_METHOD'] == "POST" ? "post" : "get");
	}
	public function execute(){
		request::initialize();
		$module = request::getModule();
		$view = request::getView();
		$base = str_replace('/html', '', getcwd());
		$executable = "$base/apps/$module/view/$view.php";
		if(is_readable($executable) && require_once($executable)){
			if(is_callable($view)){
				$base = str_replace('/html', '', getcwd());
				if(call_user_func($view, $base)){
					return true;
				} else {
					return response::error404();
				}
			} else {
				error_log("$executable file not found.");
				return response::error404();
			}
		} else {
			error_log("$executable file not found.");
			return response::error404();
		}
	}
	public function initialize(){
		$result = database::query("SELECT * FROM `setting`");
		if($result && $result->num_rows > 0){
			global $site_settings;
			while($site_setting = $result->fetch_assoc()){
				$site_settings[$site_setting['key']] = $site_setting['value'];
			}
			return true;
		} else {
			return false;
		}
	}
	public function log($latency){
		return database::query(sprintf("INSERT INTO `log` (`latency`, `post`, `server`, `session`, `ip_address`, `creationTime`) VALUES('%s', '%s', '%s', '%s', '%s', %d)", $latency, json_encode(database::json($_POST)), json_encode(database::json($_SERVER)), json_encode(database::json($_SESSION)), database::sanitize($_SERVER['REMOTE_ADDR']), time()));
	}
}
?>
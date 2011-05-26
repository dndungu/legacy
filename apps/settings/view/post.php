<?php
function post(){
  header("Content-type: application/javascript");
  $action = isset($_GET['action']) ? trim($_GET['action']) : NULL;
  switch($action){
    case "edit":
      require("../modules/setting/model/settingUpdate.php");
      $setting = settingUpdate();
      break;
  }
  require("../modules/setting/model/settingRead.php");
  $response = json_encode(settingRead());
  $callback = isset($_GET['callback']) ? $_GET['callback'] : "callback";
  print $callback."($response);";
  return true;  
}
?>
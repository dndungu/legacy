<?php
function get(){
  print isset($_GET['callback']) ? $_GET['callback'] : "callback";
  try {
    header("Content-type: application/javascript");
    require("../modules/setting/model/settingRead.php");
    $action = isset($_GET['action']) ? trim($_GET['action']) : NULL;
    switch($action){
      case "list":
        $settings = settingRead();
        break;
      case "item":
        $settings = settingRead($_GET["setting"]);
        break;
      default:
        $settings = array();
        break;
    }
    print "(".json_encode(utf8json($settings)).")";
    return true;    
  } catch (Exception $e) {
    print "(".json_encode($e->getMessage()).")";
    return false;
  }
}
?>
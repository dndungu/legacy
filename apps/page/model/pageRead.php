<?php
function pageRead($page = NULL){
  try {
    $read = sprintf("SELECT * FROM `page` WHERE `page`.`ID` = %d LIMIT 1", e($page));
    if(is_null($page)){
      $read = "SELECT * FROM `page` WHERE `inTrash` = 'No' ORDER BY `weight`";
    }
    if($result = db_query($read)){
      if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
          $rows[] = $row;
        }
      }
      return isset($rows) ? $rows : array();
    } else {
      return false;
    }
  } catch (Exception $e){
    return false;
  }
}
?>
<?php
function pageTrash($page){
  try {
    $delete = sprintf("UPDATE `page` SET `inTrash` = 'Yes' WHERE `page` = %d LIMIT 1", e($page));
    if($result = db_query($delete)){
      return mysqli_affected_rows($db_link);
    } else {
      throw new Exception(mysql_error($db_link));
      return false;      
    }
  } catch (Exception $e) {
    return false;
  }
}
?>
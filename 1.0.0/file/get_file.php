<?php

function get_user_uploads($user_iin) {
  // Initializing the database
  global $db;

  // Executing the query
  return $db->query("SELECT `file_name` FROM `Files` WHERE `file_author` = '$user_iin'")->fetch_all(MYSQLI_ASSOC);
} 

function get_all_uploads() {
  // Initializing the database
  global $db;

  // Executing the query
  return $db->query("SELECT `file_name`, `file_author` FROM `Files`")->fetch_all(MYSQLI_ASSOC);
}

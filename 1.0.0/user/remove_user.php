<?php

// Функция ограничить доступ пользователю
function remove_user(){
  // Подключаем базу данных
  global $db;

  // Берем параметр
  if (!isset($_POST["iin"])) {
    error("WRONG DATA", 400);
  }

  $iin = $_POST["iin"];

  $db->query("UPDATE `Users` SET `user_role_id` = '0', `user_password` = NULL WHERE `user_iin` = '$iin'");

  if ($db->affected_rows > 0) {
    error("OK", 200);
  } else {
    error("BAD REQUEST", 400);
  }
}

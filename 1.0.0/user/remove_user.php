<?php

// Функция ограничить доступ пользователю
function remove_user(){
  // Подключаем базу данных
  global $db;

  // Берем параметр
  if (isset($_POST["iin"])) {
    error("Введены неправильные параметры", 400);
  }

  $iin = $_POST["iin"];

  $db->query("UPDATE `Users` SET `user_role_id` = '0' WHERE `user_iin` = '$iin'");

  if ($db->affected_rows > 0) {
    error("Пользователь успешно ограничен в доступе", 200);
  } else {
    error("Произошла ошибка при выполнении запроса", 400);
  }
}

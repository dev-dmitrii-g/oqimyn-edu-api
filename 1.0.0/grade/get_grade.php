<?php

// Получение оценок
function get_grade(string $iin) {
  // Инициализация базы данных
  global $db;

  // Запрос на получение
  return $db->query("SELECT `g_grade`, `g_task_id`, `g_date` FROM `Grades` WHERE `g_user_iin` = '$iin'")->fetch_all(MYSQLI_ASSOC);
  
}

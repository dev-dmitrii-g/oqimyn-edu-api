<?php


function get_lesson(int $lesson_id = 0) {
    global $db;

    $lesson = $db->query("SELECT * FROM Lessons WHERE lesson_id = $lesson_id")->fetch_assoc();

    return ($lesson) ? $lesson : [];
}

function get_lesson_list() {
    global $db;

    return $db->query("SELECT * FROM Lessons")->fetch_all(MYSQLI_ASSOC);
}

function get_teacheers_list(int $lesson_id) {
    global $db;

    return $db->query("SELECT DISTINCT user_first_name, user_last_name, IFNULL(`user_middle_name`, '') as `user_middle_name` FROM `Users`, `Lesson_Teachers` WHERE Lesson_Teachers.lesson_id = '$lesson_id' AND Lesson_Teachers.teacher_iin = Users.user_iin")->fetch_all(MYSQLI_ASSOC);
}
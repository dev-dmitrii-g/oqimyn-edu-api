<?php


function delete_lesson(int $lesson_id = 0): void {

    global $db;

    $db->query("DELETE FROM Lessons WHERE lesson_id = $lesson_id");

}
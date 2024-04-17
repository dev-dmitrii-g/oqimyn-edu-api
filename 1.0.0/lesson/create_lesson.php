<?php

function create_lesson(string $name = ''): void {

    global $db;
    $db->query("INSERT INTO `Lessons` (`lesson_name`) VALUES ('$name')");

}
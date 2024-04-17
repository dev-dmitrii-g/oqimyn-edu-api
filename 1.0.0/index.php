<?php

include "model.php";
include "./database.php";

$class_names = [
    "user" => "user",
    "notification" => "notification",
    "group" => "group",
    "lesson" => "lesson",
    "specialization" => "specialization",
    "teacher" => "teacher",
    "module" => "module",
    "grade" => "grade"
];

$router = array_splice($router, 1);

foreach($class_names as $class_key => $class_value) {
    include $class_key."/index.php";
    $current_class = new $class_key($class_value);

    if ($current_class->get_route() == $router[0]) {
        return $current_class->execute();
    }
}

error("Incorrect model", 200);


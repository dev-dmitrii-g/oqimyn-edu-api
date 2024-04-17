<?php

class lesson extends model {
    public function __construct(string $route) {
        $this->route = $route;
        $this->routes = [
            "create" => [],
            "delete" => [],
            "get" => [
                "list" => [],
                "teachers" => []
	    ],
	    "assign" => []
        ];
    }

    public function get_route(): string {
        return $this->route;
    }

    public function execute(): void {
        global $router, $db;
        $router = (count($router) > 1) ? array_splice($router, 1): $router;

        if (array_key_exists($router[0], $this->routes)) {
            $routes = array_keys($this->routes);

            switch ($router[0]) {
                case $routes[0]:
                    include 'create_lesson.php';

                    $name = $_POST['lesson_name'];
                    create_lesson($name);
                    json_response(array(
                        "message" => "Lesson created!"
                    ));
                    break;

                case $routes[1]:
                    include 'delete_lesson.php';

                    $lesson_id = $_POST['lesson_id'];
                    delete_lesson($lesson_id);
                    json_response(array(
                        "message" => "Lesson deleted!"
                    ));
                    break;

                case $routes[2]:
                    include 'get_lesson.php';
                    $lessonList = array_keys($this->routes['get']);
                    switch ($router[1]) {
                        case $lessonList[0]:
                            json_response(get_lesson_list());
                            break;
                        case $lessonList[1]:
                            $lesson_id = $_POST["lesson_id"];
                            json_response(get_teacheers_list($lesson_id));
                            break;
                        default: json_response(get_lesson($router[1]));
                    }
		    break;
		case $routes[3]:
			include "assign_teacher.php";

			$lesson_id = $_POST["lesson_id"];
			$teacher_iin = $_POST["teacher_iin"];

			assign_teacher(intval($lesson_id), $teacher_iin);

			break;
            default: error("Route is not found", 200);
            }
        }
    }
}

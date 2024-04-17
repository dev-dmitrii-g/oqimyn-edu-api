<?php

class schedule extends model {
    public function __construct(string $route) {
        $this->route = $route;
        $this->routes = [
            "create" => [],
            "delete" => [],
            "edit" => [],
            "get" => [],
            "list" => []
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
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $lesson_teacher_id = $_POST['lesson_teacher_id'];
                        $lesson_type = $_POST['lesson_type'];
                        $lesson_date = $_POST['lesson_date'];
                        $lesson_start_time = $_POST['lesson_start_time'];
                        $lesson_end_time = $_POST['lesson_end_time'];
                        if(empty($lesson_teacher_id) || empty($lesson_type) || empty($lesson_date) || empty($lesson_start_time) || empty($lesson_end_time)) {
                            error("Bad request", 404);
                        }else {
                            include 'create_sc.php';
                            create_sc(
                                $lesson_teacher_id,
                                $lesson_type,
                                $lesson_date,
                                $lesson_start_time,
                                $lesson_end_time
                            );

                        }
                    } else {
                        error("Invalid request method", 400);
                    }
                    break;
                case $routes[1]:
                    include "delete_sp.php";

                    $code = $_POST["code"]; // Код
                    delete_notification($code);
                    break;
            }
        }
    }
}

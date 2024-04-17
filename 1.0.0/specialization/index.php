<?php

class specialization extends model {
    public function __construct(string $route) {
        $this->route = $route;
        $this->routes = [
            "create" => [],
            "delete" => [],
            "edit" => [],
            "get" => [],
            "list" => [],
            "search" => []
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
                    include "create_sp.php";

                    $name = $_POST["name"]; // Название
                    $code = $_POST["code"]; // Код
                    $edu_base = $_POST["edu_base"]; // База обучения
                    $department = $_POST["department"]; // Отделение
                    $duration = $_POST["duration"]; // Время
                    $language = $_POST["language"]; // Язык

                    if(empty($name) || empty($code) || empty($edu_base) || empty($department) || empty($duration) || empty($language)) {
                        error("Пожалуйста, заполните все обязательные поля", 400);
                    }else {
                        create_sp($name, $code, $edu_base, $department, $duration, $language);
                    }
                    break;
                case $routes[1]:
                    include "delete_sp.php";

                    $code = $_POST["code"]; // Код
                    delete_notification($code);
                    break;
                case $routes[2]:
                    include "edit_sp.php";
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {

                        $id = $_POST["id"];
                        $name = $_POST["name"] ?? NULL; // Название
                        $code = $_POST["code"] ?? NULL; // Код
                        $edu_base = $_POST["edu_base"] ?? NULL; // База обучения
                        $department = $_POST["department"] ?? NULL; // Отделение
                        $duration = $_POST["duration"] ?? NULL; // Время
                        $language = $_POST["language"] ?? NULL; // Язык

                        edit_sp(intval($id), $name, $code, $edu_base, $department, $duration, $language);

                        } else {
                            error("Invalid request method", 400);
                        }
                        break;
                    case $routes[3]:
                        include "get_sp.php";

                        $code = $_POST["code"]; // Код
                        json_response(get_sp($code));
                        break;
                    case $routes[4]:
                        include "list_sp.php";
                        json_response(list_sp());
                        break;
                    case $routes[5]:
                        include "search_sp.php";
                        if(!isset($_POST['name'])) {
                            error('Специальность не найден', 400);
                        }
                        $name = $_POST["name"]; // Код
                        json_response(search_sp($name));
                        break;
            }
        }
    }
}

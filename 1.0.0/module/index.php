<?php

class module extends model {
    public function __construct(string $route) {
        $this->route = $route;
        $this->routes = [
            "create" => [],
            "delete" => [],
            "edit" => [],
            "add-access" => [],
            "get" => [
                "list-all" => []
            ],
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
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
            switch ($router[0]) {
                case $routes[0]:
                    include "create_md.php";

                    $name = $_POST["name"]; // Название
                    $year = $_POST["year"]; // Курс
                    $spec = $_POST["spec"]; // Специализация

                    create_md($name, $year, $spec);
                    break;
                case $routes[1]:
                    include "delete_md.php";

                    delete_md();
                    break;
                case $routes[2]:
                    break;
                case $routes[6]:
                    include 'search_md.php';
                    $name = $_POST['name'];
                    json_response(search_module($name));
                    break;
                case $routes[3]:
                    include "add_access_md.php";
                    $name = $_POST["name"];
                    $iin = $_POST["iin"];
                    add_access_md($name, $iin);
                    break;
                case $routes[4]:
                    $module_list = array_keys($this->routes['get']);
                    include "get_md.php";
                    switch($router[1]) {
                        case $module_list[0]: // Показать все доступные модули
                            json_response(list_all_modules());
                            break;
                        

                    }
                }
            } else {
                error("Invalid request method", 400);
            }
        }
    }
}

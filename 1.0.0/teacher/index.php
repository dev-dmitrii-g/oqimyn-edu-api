<?php

class teacher extends model {
    public function __construct(string $route) {
        $this->route = $route;
        $this->routes = [
            "add" => [],
            "remove" => [],
            "get" => []
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
                    include "te_add.php";
                    $iin = $_POST["iin"];
                    te_add($iin);
                    break;
                case $routes[1]:
                    include "te_remove.php";
                    $iin = $_POST["iin"];
                    te_remove($iin);
                    break;
                case $routes[2]:
                    include "te_get.php";
                    $iin = $_POST["iin"];
                    json_response(te_get($iin));
                    break;
                } 
            } else {
                error("Неверный метод запроса", 400);
            }
        }
    }
}
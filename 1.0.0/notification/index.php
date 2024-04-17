<?php

class notification extends model {
    public function __construct(string $route) {
        $this->route = $route;
        $this->routes = [
            "create" => [],
            "delete" => [],
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

        switch ($router[0]) {
            case $routes[0]:
                include "create_notification.php";

                // Executing the function
                create_notification();
                break;

            case $routes[1]:
                include "delete_notification.php";

                $id = $_POST["id"];
                delete_notification($id);
                break;
            
            case $routes[2]:
                include "get_notifications.php";
                json_response(array_merge(get_notification(), get_everyone_notification()));
                break;
            }
        }
    }
}
<?php

class group extends model {
    public function __construct(string $route) {
        $this->route = $route;
        $this->routes = [
            "create" => [],
            "edit" => [],
            "delete" => [],
            "user" => [
                "add" => [],
                "delete" => []
            ],
            "get" => [
                "users" => [],
                "list" => []
            ],
            "search" => [],
            "search_groups" => []
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
                include "create_group.php";
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $group_name = $_POST["group_name"];
                    $group_year = intval($_POST["group_year"]) ?? 0;
                    $group_specialty = $_POST["group_specialty"];
                    $group_mentor_iin = $_POST["group_mentor_iin"];
                    $group_department = $_POST["group_department"];
                    $group_study_type = $_POST["group_study_type"];
                    if (empty($group_name) || empty($group_year) || empty($group_specialty) || empty($group_mentor_iin) || empty($group_department) || empty($group_study_type)) {
                        error("Пожалуйста, заполните все обязательные поля", 400);
                    } else {
                        create_group($group_name, $group_year, $group_specialty, $group_mentor_iin, $group_department, $group_study_type);
                    }

                    }
                    break;
            case $routes[1]:
                include "edit_group.php";

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $group_id = $_POST["group_id"];
                    $group_name = $_POST["group_name"] ?? NULL;
                    $group_year = intval($_POST["group_year"]) ?? 0;
                    $group_specialty = $_POST["group_specialty"] ?? NULL;
                    $group_mentor_iin = $_POST["group_mentor_iin"] ?? NULL;
                    $group_department = $_POST["group_department"] ?? NULL;
                    $group_study_type = $_POST["group_study_type"] ?? NULL;
                    if (empty($group_id) || empty($group_name) || empty($group_year) || empty($group_specialty) || empty($group_mentor_iin) || empty($group_department) || empty($group_study_type)) {
                        error("Пожалуйста, заполните все обязательные поля", 400);
                    } else {
                        edit_group($group_id, $group_name, $group_year, $group_specialty, $group_mentor_iin, $group_department, $group_study_type);
                    }

                }
                break;
            case $routes[5]:
                include "search_group.php";
                $group_name = $_POST['group_name'] ?? '';
                json_response(search_group($group_name));
                break;
            case $routes[6]:
                include "search_group.php";
                $group_name = $_POST['group_name'] ?? '';
                json_response(search_groups($group_name));
                break;
            case $routes[3]:
                include "edit_group.php";
                include "delete_group.php";
                $group_id = $_POST['group_id'] ?? 0;
                $user_iin = $_POST['user_iin'] ?? '';
                $userList = array_keys($this->routes['user']);
                switch ($router[1]) {
                    case $userList[0]:
                        if(add_user(intval($group_id), $user_iin)) {
                            json_response(array(
                                'message' => 'User added to group!'
                            ));
                        }else {
                            json_response(array(
                                'message' => 'User iin or Group id not found!'
                            ));
                        }
                        break;
                    case $userList[1]:
                        if(delete_user(intval($group_id), $user_iin)) {
                            json_response(array(
                                'message' => 'User deleted from group!'
                            ));
                        }else {
                            json_response(array(
                                'message' => 'User iin or Group id not found!'
                            ));
                        }
                        break;
                }
                break;
            case $routes[4]:
                include "get_group.php";
                $group_id = $_POST['group_id'] ?? 0;
                $userList = array_keys($this->routes['get']);
                switch ($router[1]) {
                    case $userList[0]:
                        json_response(get_users($group_id));
                        break;
                    case $userList[1]:
                        json_response(get_groups());
                        break;
                }
                break;
            case $routes[2]:
                include "delete_group.php";
                $group_id = $_POST['group_id'] ?? 0;
                if(delete_group(intval($group_id))) {
                    json_response(array(
                        'message' => 'Group deleted!'
                    ));
                }else {
                    json_response(array(
                        'message' => 'Group not found!'
                    ));
                }
                break;
            default: error("Route is not found", 200);
            }

        }

    }
}
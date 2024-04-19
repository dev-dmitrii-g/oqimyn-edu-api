<?php

class file extends model {
    public function __construct(string $route) {
        $this->route = $route;
        $this->routes = [
            "upload" => [], // upload file 
            "remove" => [], // delete file
            "get" => [
              "user-uploads" => [],
              "all-uploads" => [],
              "upload" => []
            ], // get file
        ];
    }

public function get_route(): string {
    return $this->route;
}

public function execute(): void {
    global $router, $db;

    // Token check 
    if (!isset($_POST["token"])) {
        error("Token not found", 400);
    }

    $token = $_POST["token"];

    $check_user = $db->prepare("SELECT 1 FROM Users WHERE user_access_token = ?");
    $check_user->bind_param("s", $token);
    $check_user->execute();
    $check_result = $check_user->get_result();

    $check_role = $db->query("SELECT user_role_id FROM Users WHERE user_access_token = '$token'")->fetch_assoc();

    if ($check_result->num_rows === 0) {
        error("User does not exist", 400);
    }

    if ($check_role["user_role_id"] < 2) {
        error("Insufficient permissions", 400);
    }

    $iin = $db->query("SELECT user_iin FROM Users WHERE user_access_token = '$token'")->fetch_assoc();

    $router = (count($router) > 1) ? array_splice($router, 1): $router;

    if (array_key_exists($router[0], $this->routes)) {
        $routes = array_keys($this->routes);

        switch ($router[0]) {
            case $routes[0]: 
              include "upload_file.php";

              $file = $_FILES['file'];
              upload_file($file, $iin['user_iin']);
              break;
            case $routes[1]:
              include "remove_file.php";
              break;
            case $routes[2]:
              include "get_file.php";
              $routes = array_keys($this->routes["get"]);

              switch($router[1]) {
              case $routes[0]:
                json_response(get_user_uploads($iin['user_iin']));
                break;
              case $routes[1]:
                json_response(get_all_uploads());
                break;
              }
              break;

            }
        }
    }
}

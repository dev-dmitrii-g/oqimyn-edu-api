<?php

class user extends model {
    public function __construct(string $route) {
        $this->route = $route;
        $this->routes = [
            "login" => [],
            "registration" => [],
            "edit" => [],
            "get" => [
                "info" => [],
                "search" => [],
                "roles" => [],
                "list" => [],
                "photo" => []
            ],
            "upload-picture" => []
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
                include "authentication.php";

                $user_data = authentication();
                if ($user_data) {
                    $token = create_token($user_data["user_iin"], $user_data["user_password"]);
                    set_token($user_data["user_iin"], $token);
                    json_response(array("token" => $token));
                    break;
                }

                error("Wrong data", 200);
                break;

                case $routes[1]:
                    include "authentication.php";
                    
                    $iin = strip_tags($_POST["iin"]);
                    $password = strip_tags($_POST["password"]);
                    $first_name = strip_tags($_POST["first_name"]);
                    $last_name = strip_tags($_POST["last_name"]);
                    $middle_name = $_POST["middle_name"] ?? NULL;
                    $birth_date = strip_tags($_POST["birth_date"]);
                    $gender = strip_tags($_POST["gender"]);
                    $phone_number = strip_tags($_POST["phone_number"]);
                    
                    if (empty($iin) || empty($password) || empty($first_name) || empty($last_name) || empty($birth_date) || empty($gender) || empty($phone_number)) {
                        // Trigger an error message
                        error("Пожалуйста, заполните все обязательные поля", 400);
                    } else {
                        // Proceed with registration if all fields are filled
                        registration($iin, $password, $first_name, $last_name, $middle_name, $birth_date, $gender, $phone_number);
                    }
                    break;

            case $routes[2]:
                    include "authentication.php";

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    $id = $_POST['id'];
                    $iin = $_POST['iin'] ?? null;
                    $password = $_POST['password'] ?? null;
                    $first_name = $_POST['first_name'] ?? null;
                    $last_name = $_POST['last_name'] ?? null;
                    $middle_name = $_POST['middle_name'] ?? null;
                    $birth_date = $_POST['birth_date'] ?? null;
                    $gender = $_POST['gender'] ?? null;
                    $phone_number = $_POST['phone_number'] ?? null;
                    $role_id = ($_POST['role_id'] === 'null') ? 0 : $_POST['role_id'] ?? 0;

                    edit($id, $iin, $password, $first_name, $last_name, $middle_name, $birth_date, $gender, $phone_number, $role_id);

                    } else {
                        error("Invalid request method", 400);
                    }
                    break;

            case $routes[3]:
                $routes = array_keys($this->routes["get"]);

                include "get.php";
                switch($router[1]) {
                    case $routes[0]:
                        if(isset($_POST['token'])) {
                            $info = get_user_info($_POST["token"]);
                            if($info) {
                                json_response($info);
                                break;
                            }
                            error("Token is incorrect", 200);
                        }else error("Bad request", 400);
                        break;

                    default: error("Route is not found", 200);

                    case $routes[1]:
                        include "search.php";
                        if(isset($_POST['iin'])) json_response(search($_POST["iin"]));
                        else error('Bad request', 400);
                        break;

                    case $routes[2]:
                        include "get_roles.php";
                        json_response(get_roles());
                        break;
                    case $routes[3]:
                        json_response(getAllUser());
                        break; 
                    case $routes[4]:
                        include "get.php";
                        getPhoto($_POST["img"]);
                        break;  
                }
                break;
                case $routes[4]:
                    include "upload_profile_picture.php";
                    $file = $_FILES['file'];
                    $token = $_POST["token"];
                    upload_profile_picture($token, $file);
                    break;
        }
        return;
    }
    error("Route is not found", 200);
}
}

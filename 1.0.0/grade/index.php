<?php

class grade extends model {
    public function __construct(string $route) {
        $this->route = $route;
        $this->routes = [
            "create" => [], // Создать
            "edit" => [], // Редактировать
            "remove" => [], // Удалить
            "get" => [], // Получить
            "average" => [], // Высчитать среднее значение
            "filter" => [] // Фильтр по дате
        ];
    }

public function get_route(): string {
    return $this->route;
}

public function execute(): void {
    global $router, $db;

    // Проверка на существование пользователя и его прав 
    if (!isset($_POST["token"])) {
        error("Токен не найден", 400);
    }

    $token = $_POST["token"];

    $check_user = $db->prepare("SELECT 1 FROM Users WHERE user_access_token = ?");
    $check_user->bind_param("s", $token);
    $check_user->execute();
    $check_result = $check_user->get_result();

    $check_role = $db->query("SELECT user_role_id FROM Users WHERE user_access_token = '$token'")->fetch_assoc();

    if ($check_result->num_rows === 0) {
        error("Данного пользователя не существует.", 400);
    }

    if ($check_role["user_role_id"] < 2) {
        error("Недостаточно прав.", 400);
    }

    $iin = $db->query("SELECT user_iin FROM Users WHERE user_access_token = '$token'")->fetch_assoc();

    $router = (count($router) > 1) ? array_splice($router, 1): $router;

    if (array_key_exists($router[0], $this->routes)) {
        $routes = array_keys($this->routes);

        switch ($router[0]) {
            case $routes[0]: 
                include "add_grade.php"; // Создать оценку
                add_grade();
                break;

            case $routes[1]:
                include "edit_grade.php"; // Редактировать оценку
                edit_grade();
                break;
            
            case $routes[2]:
                include "remove_grade.php"; // Удалить оценку
                remove_grade();
                break;
            case $routes[3]:
                include "get_grade.php"; // Получить оценку
                json_response(get_grade($iin["user_iin"]);
                break;

            case $routes[4]:
                include "average_grade.php"; // Среднее значение
                average_grade();
                break;
            
            case $routes[5]:
                include "filter_grade.php"; // Фильтр по дате
                filter_grade();
                break;
            }
        }
    }
} 

<?php

// Абстрактный модель классов API 1.0.0
abstract class model {

    // Основной путь
    protected string $route;
    // Массив путей от основного
    protected array $routes;

    public function __construct(string $route = '')
    {
        $this->route = $route;
    }

    // Абстрактная Функция для получение основного пути для проверки и инициализаций
    abstract public function get_route(): string;
    // Абстрактная Функция для выполнение кода
    abstract public function execute(): void;

}


?>
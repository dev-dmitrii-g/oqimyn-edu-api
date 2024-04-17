<?php
// API версия
$api_versions = (array) ["1.0.0"];

// Проверка версии API
function check_api_version(string $api_version = "1.0.0"): bool {
    global $api_versions;
    return in_array($api_version, $api_versions);
};
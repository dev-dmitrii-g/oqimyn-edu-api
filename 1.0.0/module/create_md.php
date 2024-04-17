<?php

function create_md(string $name, string $year, string $spec) {
    global $db;

    if(!$db->query("SELECT sp_code FROM `Specializations` WHERE sp_code = '$spec'")->fetch_assoc()) return error("Код специальности существует", 404);

    $stmt = $db->prepare("INSERT INTO `Modules` (md_name, md_year, md_specialization) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $year, $spec);
    $stmt->execute();

	if ($stmt->affected_rows > 0) {
        return error("Модуль успешно добавлен", 200);
    } else {
        return error("Произошла ошибка при добавлении модуля", 400);
    }
}

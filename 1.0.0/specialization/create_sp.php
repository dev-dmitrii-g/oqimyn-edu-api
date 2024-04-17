<?php

function create_sp(
	string $name, 
	string $code, 
	string $edu_base, 
	string $department, 
	string $duration, 
	string $language
) {
	// Init DB
	global $db;

    if($db->query("SELECT sp_code FROM `Specializations` WHERE sp_code = '$code'")->fetch_assoc()) return error("Код специальности существует", 404);

	$stmt = $db->prepare("INSERT INTO `Specializations` (sp_name, sp_code, sp_edu_base, sp_department, sp_duration, sp_language) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("ssssss", $name, $code, $edu_base, $department, $duration, $language);
	$stmt->execute();

	if ($stmt->affected_rows > 0) {
		return error("Specialization successfully added", 200);
	} else {
		return error("Failed to add specialization", 400);
	}
}

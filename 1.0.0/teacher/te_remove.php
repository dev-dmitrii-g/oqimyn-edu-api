<?php

function te_remove(string $iin) {
	global $db;
	$stmt = $db->prepare("DELETE FROM `Teachers` WHERE te_iin = ?");
	$stmt->bind_param("s", $iin);
	$stmt->execute();
	if ($stmt->affected_rows > 0) {
		return error("Учитель успешно удален", 200);
	} else {
		return error("Произошла ошибка при удалении учителя", 400);
	}
}

<?php
function assign_teacher($lesson_id, $teacher_iin) {
    global $db;

    $stmt = $db->prepare("INSERT INTO `Lesson_Teachers` (lesson_id, teacher_iin) VALUES (?, ?)");
    $stmt->bind_param("is", $lesson_id, $teacher_iin);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        return error("Successfully assigned", 200);
    } else {
        return error("Failed to assign", 400);
    }
}

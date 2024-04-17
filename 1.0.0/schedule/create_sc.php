<?php

function create_sc(
	string $lesson_teacher_id,
	string $type,
    string $date,
	string $start_time,
	string $end_time
) {
	// Init DB
	global $db;

    $lesson_teacher = $db->query(
        "SELECT 
        Users.user_first_name, 
       Users.user_last_name, 
       Users.user_middle_name, 
       Lessons.lesson_name 
        FROM `Lesson_Teachers`, `Users`, `Lessons` 
        WHERE id = $lesson_teacher_id AND 
              Users.user_iin = Lesson_Teachers.teacher_iin AND 
              Lessons.lesson_id = Lesson_Teachers.lesson_id"
    )->fetch_assoc();

    $teacher_fullName = $lesson_teacher['user_last_name']." ".mb_substr($lesson_teacher['user_first_name'], 0, 1).". ".mb_substr($lesson_teacher['user_middle_name'], 0, 1);
    $lesson_name = $lesson_teacher['lesson_name'];
	$stmt = $db->prepare("INSERT INTO `Schedules` (sc_lesson_name, sc_teacher_name, sc_type, sc_date, sc_start_time, sc_end_time) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("ssssss", $lesson_name, $teacher_fullName, $type, $date, $start_time, $end_time);
	$stmt->execute();

	if ($stmt->affected_rows > 0) {
		return error("Schedule successfully added", 200);
	} else {
		return error("Failed to add schedule", 400);
	}
}

<?php
function upload_profile_picture($token, $file)
{
    // Check if a file was uploaded successfully
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return "Error uploading file.";
    }

    // Validate file type and size (you can customize this)
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 5 * 1024 * 1024; // 5MB

    if (!in_array($file['type'], $allowed_types)) {
        return "Данный файл не поддерживается. Загрузите изображение в данных форматах (JPEG, PNG, GIF).";
    }

    if ($file['size'] > $max_size) {
        return "Файл слишком большой. Максимальный размер файла 5МБ.";
    }

    // Generate a unique filename
    $file_name = uniqid('profile_') . '_' . $file['name'];
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION); 

    // Move the uploaded file to a directory (adjust the path as needed)
    $file_name = hash('sha256',$file_name).'.'.$file_extension;

    if (!move_uploaded_file($file['tmp_name'], 'images/'.$file_name)) {
        return "Error moving file to destination.";
    }

    // Update the database with the file path
    global $db;
    $stmt = $db->prepare("UPDATE Users SET user_profile_picture = ? WHERE user_access_token = ?");
    $stmt->execute([$file_name, $token]);

    return "Profile picture uploaded successfully.";
}

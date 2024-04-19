<?php

function upload_file($file, $file_author) {
  // Check if the file was uploaded successfully
  if ($file['error'] !== UPLOAD_ERR_OK) {
    error("There was an error while uploading file", 400);
  }

  // Maximum file size
  $max_size = 25 * 1024 * 1024; // 25MB
  
  if ($file['size'] > $max_size) {
    error("File size is too large", 400);
  }

  // Generate a unique file name
  $file_name = uniqid('file_') .  '_' . $file['name'];
  $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);

  $file_name = hash('sha256', $file_name) . '.' . $file_extension;

  // Check if the destination directory exists and move the file
  $destination_dir = 'files/';
  if (!file_exists($destination_dir)) {
    mkdir($destination_dir, 0777, true);
  }

  if (!move_uploaded_file($file['tmp_name'], $destination_dir . $file_name)) {
    error("Failed to move uploaded file", 500);
  }

  // Initializing the database
  global $db;

  // Preparing the statement
  $insert_file = $db->prepare("INSERT INTO `Files` (`file_name`, `file_author`) VALUES (?, ?)");
  $insert_file->bind_param("ss", $file_name, $file_author);
  $insert_file->execute();

  error("File uploaded successfully", 200);
}

<?php

function add_access_md(string $name, string $iin) {
    global $db;

    // Query Modules table to get md_id based on md_name
    $stmt_module = $db->prepare("SELECT md_id FROM Modules WHERE md_name = ?");
    $stmt_module->bind_param("s", $name);
    $stmt_module->execute();
    $result_module = $stmt_module->get_result();

    // Check if module exists
    if ($result_module->num_rows > 0) {
        $module_row = $result_module->fetch_assoc();
        $md_id = $module_row['md_id'];

        // Insert into Module_Access using md_id
        $stmt_access = $db->prepare("INSERT INTO Module_Access (ma_md_id, ma_user_iin) VALUES (?, ?)");
        $stmt_access->bind_param("is", $md_id, $iin);
        $stmt_access->execute();

        // Close statements
        $stmt_access->close();
    } else {
        // Module not found, handle error
        echo "Module not found.";
    }

    // Close statements
    $stmt_module->close();
    
}

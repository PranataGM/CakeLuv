<?php
require 'app/Config/config.php';
require 'app/Core/Database.php';

$db = new Database();

try {
    $db->query("ALTER TABLE users 
                ADD COLUMN verification_token VARCHAR(255) NULL, 
                ADD COLUMN is_verified TINYINT(1) DEFAULT 0, 
                ADD COLUMN reset_token VARCHAR(255) NULL, 
                ADD COLUMN reset_expires DATETIME NULL");
    $db->execute();
    
    // Auto-verify existing users (like admin)
    $db->query("UPDATE users SET is_verified = 1");
    $db->execute();
    
    echo "Migration Success";
} catch(PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
        echo "Already Migrated";
    } else {
        echo "Error: " . $e->getMessage();
    }
}

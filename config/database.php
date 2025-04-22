<?php
// Database connection configuration
$host = 'localhost';
$db_name = 'propile_db';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

// DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";

// Options for PDO connection
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Try to create a PDO instance
try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // Handle connection error
    die("Connection failed: " . $e->getMessage());
}

// Function to check if the database exists and create it if it doesn't
function initialize_database() {
    global $host, $username, $password, $db_name, $charset;
    
    try {
        // Connect without specifying database
        $pdo = new PDO("mysql:host=$host;charset=$charset", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create database if it doesn't exist
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` DEFAULT CHARACTER SET $charset COLLATE ${charset}_unicode_ci");
        
        // Connect to the database
        $pdo->exec("USE `$db_name`");
        
        // Create users table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `users` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `username` VARCHAR(50) NOT NULL UNIQUE,
                `email` VARCHAR(100) NOT NULL UNIQUE,
                `password` VARCHAR(255) NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=$charset COLLATE=${charset}_unicode_ci
        ");
        
        // Create profiles table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `profiles` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `user_id` INT NOT NULL,
                `full_name` VARCHAR(100),
                `title` VARCHAR(100),
                `bio` TEXT,
                `profile_pic` VARCHAR(255),
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=$charset COLLATE=${charset}_unicode_ci
        ");
        
        // Create education table with level field
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `education` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `user_id` INT NOT NULL,
                `level` ENUM('school', 'college', 'university') NOT NULL,
                `institution` VARCHAR(100) NOT NULL,
                `degree` VARCHAR(100),
                `field` VARCHAR(100),
                `year` INT,
                `percentage` VARCHAR(20),
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=$charset COLLATE=${charset}_unicode_ci
        ");
        
        // Create projects table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `projects` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `user_id` INT NOT NULL,
                `title` VARCHAR(100) NOT NULL,
                `description` TEXT,
                `github_link` VARCHAR(255),
                `live_link` VARCHAR(255),
                `image` VARCHAR(255),
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=$charset COLLATE=${charset}_unicode_ci
        ");
        
        // Create social_links table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `social_links` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `user_id` INT NOT NULL,
                `platform` VARCHAR(50) NOT NULL,
                `url` VARCHAR(255) NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=$charset COLLATE=${charset}_unicode_ci
        ");
        
        // Create portfolio_templates table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `portfolio_templates` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(100) NOT NULL,
                `description` TEXT,
                `preview_image` VARCHAR(255),
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=$charset COLLATE=${charset}_unicode_ci
        ");
        
        // Create user_portfolios table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `user_portfolios` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `user_id` INT NOT NULL,
                `template_id` INT NOT NULL,
                `custom_domain` VARCHAR(255),
                `is_published` BOOLEAN DEFAULT FALSE,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
                FOREIGN KEY (`template_id`) REFERENCES `portfolio_templates`(`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=$charset COLLATE=${charset}_unicode_ci
        ");
        
        // Insert default templates
        $templateCheck = $pdo->query("SELECT COUNT(*) FROM `portfolio_templates`")->fetchColumn();
        
        if ($templateCheck == 0) {
            $pdo->exec("
                INSERT INTO `portfolio_templates` (`name`, `description`) VALUES 
                ('Modern Minimal', 'A clean, minimalist design with focus on content'),
                ('Developer Portfolio', 'Perfect for showcasing coding projects and skills'),
                ('Creative Portfolio', 'Colorful and dynamic design for creative professionals')
            ");
        }
        
        echo "Database initialized successfully!";
    } catch (PDOException $e) {
        die("Database initialization failed: " . $e->getMessage());
    }
}
?>
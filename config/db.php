<?php
$host_name = "localhost";
$user = "root";
$pass = "";
$database = "vaultfurniture_database";

$db = new mysqli($host_name, $user, $pass, $database);

if ($db->connect_error) {
    die($db->error);
} else {
    // CREATE USER TABLE
    $db->query("CREATE TABLE IF NOT EXISTS `users` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
        `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL UNIQUE,
        `password` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
        `role` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'user',
        `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");

    //CREATE CATEGORY TABLE
    $db->query("CREATE TABLE IF NOT EXISTS `categories`(
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `name` varchar(100) NOT NULL,
        `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");
    
    // CREATE PRODUCTS TABLE
    $db->query("CREATE TABLE IF NOT EXISTS `products` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `category_id` INT UNSIGNED NOT NULL,
        `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
        `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
        `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
        `price` decimal(10,2) NOT NULL,
        `qty_available` INT UNSIGNED NOT NULL,
        `status` enum('Available','Unavailable') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Available',
        `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");

    // CREATE ORDERS TABLE
    $db->query("CREATE TABLE IF NOT EXISTS orders (
        `id` VARCHAR UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT UNSIGNED NOT NULL,
        `location` VARCHAR(200) NOT NULL,
        `total` decimal(10,2) NOT NULL,
        `status` ENUM('pending', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
        `createdAt` timestamp DEFAULT CURRENT_TIMESTAMP,
        `updatedAt` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");

    // CREATE ORDER ITEMS TABLE
    $db->query("CREATE TABLE IF NOT EXISTS order_items(
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `order_id` VARCHAR UNSIGNED NOT NULL,
        `product_id` INT UNSIGNED NOT NULL,
        `price` DECIMAL(10,2) NOT NULL,
        `quantity` INT UNSIGNED NOT NULL DEFAULT 1,
        `createdAt` timestamp DEFAULT CURRENT_TIMESTAMP,
        `updatedAt` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");

     // Create the Contact Table
    $db->query("CREATE TABLE IF NOT EXISTS contact (
        id INT(255) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        fullname VARCHAR(100),
        email VARCHAR(50),
        phone VARCHAR(20) NULL,
        message VARCHAR(500),
        status ENUM('Read', 'Unread') DEFAULT 'Unread',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci, ENGINE=InnoDB");
}
?>
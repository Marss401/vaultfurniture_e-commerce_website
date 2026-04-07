<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define BASE_URL if not defined
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/vaultfurniture/');
}

// Include database connection
require_once __DIR__ . '/../config/db.php';

// GLOBAL STATE
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
$isLoggedIn = isset($_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vault Furniture :: Home</title>

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" defer></script>

    <!-- Scripts -->
    <script src="<?= BASE_URL ?>./assets/js/jquery.min.js"></script>
    <script src="<?= BASE_URL ?>./assets/js/sweetalert.min.js"></script>
    <script src="<?= BASE_URL ?>./assets/js/script.js" defer></script>

    <style type="text/tailwindcss">
        *, *::before, *::after {
            scroll-behavior: smooth;
            outline: none !important;
            transition: all .35s ease-in-out;
        }
        @theme {
            --color-primary: #fefefe;
            --color-dark-text: #141414;
            --color-secondary: #98989d;
            --color-tertiary: #555555;
            --color-grey: #363231;
            --color-bluish: #afc3d3;
            --color-yellowish: #f5dea7;
        }
    </style>
</head>

<body style="font-family: 'Plus Jakarta Sans', sans-serif; font-optical-sizing: auto;" class="pt-20">
    <header class="bg-primary md:p-2 px-4 md:rounded-full fixed top-0 left-0 md:top-4 md:left-1/2 md:-translate-x-1/2 w-full text-dark-text md:container z-50 shadow-lg">
        <div class="container mx-auto relative flex justify-between items-center gap-4 p-4 md:p-0">
            <!-- Logo -->
            <a href="<?= BASE_URL ?>" class="flex gap-2 items-center text-dark-text">
                <div class="h-10 w-10 bg-dark-text text-primary rounded-full grid place-items-center flex-shrink-0 md:text-xl">
                    <i class="fa-solid fa-couch"></i>
                </div>
                <h1 class="text-lg md:text-xl whitespace-nowrap font-extrabold tracking-tighter">Vault Furniture</h1>
            </a>

            <!-- Navlinks -->
            <nav id="navbar" class="flex-1 absolute w-full md:static top-full left-full transition-all duration-300 flex flex-col md:flex-row justify-center md:items-center md:gap-2">
                <?php
                $nav_links = [
                    ["slug" => "./", "title" => "Home"],
                    ["slug" => "store", "title" => "Products"],
                    ["slug" => "about", "title" => "About Us"],
                    ["slug" => "contacts", "title" => "Contact"]
                ];

                $request_uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
                $segments = explode("/", $request_uri);
                $current_page = explode("?", $segments[count($segments) - 1])[0];

                foreach ($nav_links as $link) {
                    $slug = $link['slug'];
                    $path = BASE_URL . $slug;
                    $title = $link['title'];

                    $is_active = ($current_page === substr($path, 2));
                    $active_class = $is_active ? 'bg-dark-text font-semibold text-primary' : 'bg-primary text-dark-text';
                    echo "<a href='$path' class='$active_class py-2 px-4 font-semibold text-dark-text hover:text-primary hover:bg-dark-text md:rounded-md whitespace-nowrap'>$title</a>";
                }
                ?>
            </nav>

            <!-- Action Icons -->
            <div class="flex items-center justify-center gap-4 w-max">
                <!-- Search -->
                <div class="searchWrapper relative flex items-center bg-gray-200 rounded-full px-4 py-2 xs:hidden max-w-[600px]">
                    <input type="text" id="searchInput"  placeholder="Search furniture..." class="flex-1 bg-transparent outline-none text-dark-text text-sm">
                    <button id="searchBtn" class="h-10 w-10 flex items-center justify-center bg-pink-400 text-white rounded-full">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
                <select
                    id="searchCategory"
                    class="hidden bg-transparent outline-none mx-3 text-sm">
                    <option value="all">All</option>
                    <option value="1">Chair</option>
                    <option value="2">Sofa</option>
                    <option value="3">Bed</option>
                    <option value="4">Cabinet</option>
                </select>
                <!-- Cart -->
                 <a href="<?= BASE_URL ?>cart" class="relative text-lg h-10 w-10 rounded-full bg-secondary grid place-items-center transition hover:text-primary text-dark-text">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="cartTotal h-4 w-4 rounded-full bg-red-500 text-xs text-white grid place-items-center absolute -top-2 -right-2 border border-white">0</span>
                </a>

                <!-- User/Profile -->
                <?php if ($isLoggedIn): ?>
                    <div class="relative group">
                        <div id="profileToggle" class="text-lg h-10 w-10 rounded-full bg-secondary grid place-items-center transition hover:text-primary text-dark-text">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div id="profileMenu" class="absolute right-0 mt-2 w-40 bg-primary shadow-lg rounded-md hidden z-50">
                            <a href="<?= BASE_URL ?>dashboard/settings" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                            <a href="<?= BASE_URL ?>logout" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>signin" class="transition text-lg hover:text-dark-text">
                        <i class="fa-solid fa-user"></i>
                    </a>
                <?php endif; ?>

                <!-- Mobile Hamburger -->
                <div id="navbarToggle" class="relative md:hidden lg:hidden text-2xl h-10 w-10 grid place-items-center text-dark-text bg-primary hover:bg-dark-text hover:text-primary rounded-lg cursor-pointer">
                    <i class="fa-solid fa-bars"></i>
                </div>
            </div>
        </div>
    </header>
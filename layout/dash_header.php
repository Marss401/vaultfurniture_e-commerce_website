<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Define BASE_URL if not defined
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/vaultfurniture');
}
if (!isset($_SESSION['id'])) header("location: ../signin");
// Include database connection
require_once __DIR__ . '/../config/db.php';
$role = $_SESSION['role'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vault Furniture :: Dashboard</title>

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

<body style="font-family: 'Plus Jakarta Sans', sans-serif; font-optical-sizing: auto;" class="bg-slate-100 text-slate-500 w-full h-full overflow-x-hidden">
    <main class="flex">
       <nav id="sideBar"
class="transition-all duration-300 bg-white w-[240px] h-screen fixed md:sticky top-0 left-0 z-40 border-r border-gray-200 flex flex-col justify-between">

    <!-- Logo -->
    <div>
        <a href="<?= BASE_URL ?>/" class="flex items-center gap-3 px-6 py-5 border-b border-gray-100">
            <div class="h-10 w-10 rounded-lg bg-indigo-100 text-indigo-600 grid place-items-center text-lg">
                <i class="fa-solid fa-couch"></i>
            </div>

            <div>
                <h1 class="text-gray-800 font-bold text-lg leading-tight">Vault</h1>
                <span class="text-xs text-gray-400 tracking-widest uppercase">Furniture</span>
            </div>
        </a>

        <!-- Navigation -->
        <div class="mt-6 px-3 space-y-1">
            <a href="<?= BASE_URL ?>/dashboard/overview"
            class="flex items-center gap-3 px-3 py-2.5 text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition">
                <i class="fa-solid fa-sliders text-sm"></i>
                Dashboard
            </a>
            <?php
            $admin_link = BASE_URL . "/dashboard/admins";
            $user_link = BASE_URL . "/dashboard/users";
            $product_link = BASE_URL . "/dashboard/products";

            echo $role === "admin" ?
            "
            <a href='$admin_link'
            class='flex items-center gap-3 px-3 py-2.5 text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition'>
                <i class='fa-solid fa-user-tie text-sm'></i>
                Admins
            </a>

            <a href='$user_link'
            class='flex items-center gap-3 px-3 py-2.5 text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition'>
                <i class='fa-solid fa-users text-sm'></i>
                Users
            </a>

            <a href='$product_link'
            class='flex items-center gap-3 px-3 py-2.5 text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition'>
                <i class='fa-solid fa-box text-sm'></i>
                Products
            </a>
            " : "";
            ?>

            <a href="<?= BASE_URL ?>/dashboard/categories"
            class="flex items-center gap-3 px-3 py-2.5 text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition">
                <i class="fa-solid fa-folder text-sm"></i>
                Categories
            </a>

            <a href="<?= BASE_URL ?>/dashboard/orders"
            class="flex items-center gap-3 px-3 py-2.5 text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition">
                <i class="fa-solid fa-wallet text-sm"></i>
                Orders
            </a>

            <a href="<?= BASE_URL ?>/dashboard/settings"
            class="flex items-center gap-3 px-3 py-2.5 text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition">
                <i class="fa-solid fa-gears text-sm"></i>
                Settings
            </a>

        </div>
    </div>
    <!-- Logout -->
    <div class="p-4 border-t border-gray-100">
        <a href="<?= BASE_URL ?>/logout"
        class="flex items-center justify-center gap-2 w-full py-2.5 text-sm font-medium text-white bg-pink-500 rounded-lg hover:bg-pink-600 transition">
            Logout
        </a>
    </div>

</nav>
        <section class="relative flex-1 min-h-[90vh] flex flex-col justify-between">
            <header class="bg-primary p-4 mb-8 flex justify-between items-center gap-4">
                <!-- Left: Greeting / User Name -->
                <div class="flex items-center gap-4">
                    <div class="h-10 w-10 rounded-full bg-indigo-100 text-indigo-600 grid place-items-center text-xl font-bold">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div>
                        <h4 class="text-gray-800 font-semibold text-base md:text-lg"><?= $_SESSION['name']; ?></h4>
                        <p class="text-xs text-gray-500">Welcome back!</p>
                    </div>
                </div>

                <!-- Right: Actions -->
                <div class="flex items-center gap-3">
                    <!-- Notifications -->
                    <a href='<?= BASE_URL ?>/dashboard/messages' class="relative bg-gray-50 h-10 w-10 grid place-items-center text-gray-600 rounded-full hover:bg-indigo-50 transition">
                        <span class="absolute top-1 right-1 h-2.5 w-2.5 rounded-full bg-pink-500 border border-white"></span>
                        <i class="fa-solid fa-bell"></i>
                    </a>

                    <!-- Sidebar Toggle -->
                    <button id="siderBarToggle" class="bg-gray-50 hover:bg-indigo-50 h-10 w-10 grid place-items-center text-gray-600 rounded-lg transition">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </button>

                    <!-- User Menu / Profile -->
                    <div class="flex items-center gap-2 cursor-pointer group relative">
                        <div class="h-10 w-10 rounded-full bg-indigo-200 text-indigo-700 grid place-items-center">
                            <i class="fa-solid fa-user-circle"></i>
                        </div>
                        <span class="hidden md:block text-gray-700 font-medium group-hover:text-indigo-600 transition">Account</span>
                        <!-- Dropdown (optional) -->
                        <div class="absolute right-0 top-full mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg opacity-0 group-hover:opacity-100 transition-all pointer-events-none group-hover:pointer-events-auto z-50">
                            <a href="<?= BASE_URL ?>/dashboard/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">Settings</a>
                            <a href="<?= BASE_URL ?>/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50">Logout</a>
                        </div>
                    </div>
                </div>
            </header>
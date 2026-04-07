<?php
session_start();

$role = $_SESSION['role'] ?? null;

session_unset();
session_destroy();

if ($role ) {
    header("Location: ./signin");
} 
exit();
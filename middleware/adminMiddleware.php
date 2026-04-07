<?php
include('./api/myfunctions.php');


if(!isset($_SESSION['user'])){
    redirect("../signin.php", "Login to continue");
    exit();
}

if($_SESSION['role'] != 'admin'){
    redirect("../index.php", "You are not authorised to access this page");
    exit();
}
?>
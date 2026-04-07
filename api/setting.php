<?php
session_start();
$folder = $_SERVER['DOCUMENT_ROOT'] . "/vaultfurniture";
require_once("$folder/config/db.php");
$table = "users";

if (isset($_POST['trigger_edit'])) {
    $fullname = $_POST['name'];
    $email = $_POST['email'];
    $email = strtolower($email);
    $password = $_POST['password'];
    $conf_password = $_POST['conf_password'];
    $current_password = $_POST['current_password'];
    $current_password = crypt($current_password, "54L7");

    $user_id = $_SESSION['id'];

    if ($password !== $conf_password) {
        echo json_encode(['error' => true, 'message' => 'Passwords do not match']);
        exit();
    }
    // Check if user is legit
    $verify_password = $db->query("SELECT password FROM $table WHERE id = $user_id AND password = '$current_password'");
    if ($verify_password->num_rows < 0) {
        echo json_encode(['error' => true, 'message' => 'Incorrect confirmation password supplied.']);
        exit();
    }
    // Check for possible duplicate emails
    $check_email = $db->query("SELECT id FROM $table WHERE email = '$email' AND id != $user_id");
    if ($check_email->num_rows > 0) {
        echo json_encode(['error' => true, 'message' => 'Email already in use by another user']);
        exit();
    }

    // Encrypt the password if not empty or use the old password (gotten from $current_password)
    $new_password = $password !== "" ? crypt($password, "54L7") : $current_password;

    // Update user information
    $update_query = $db->query("UPDATE $table SET fullname = '$fullname', email = '$email', password = '$new_password' WHERE id = $user_id");
    if($update_query){
        echo json_encode(['error' => false, 'message' => 'Profile updated successfully!']);
    }
    else{
        echo json_encode(['error' => true, 'message' => 'Unable to update your profile. Please, try again.']);
    }
    // $update_query = $db->query("UPDATE")
    // "UPDATE $table SET fullname='$fullname'"
}




<?php
session_start();
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/vaultfurniture/');
}
require_once __DIR__ . '/../config/db.php';
$table = "users";

//SIGNUP AUTH
if (isset($_POST["trigger_signup"])) {
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $email = strtolower(trim($_POST["email"]));
    $password = ($_POST["password"]);
    $confirm_password = $_POST["confirm_password"];
    $role = $_POST["role"];


    //check if all the input fields have value
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password)) {
        echo json_encode(["error" => true, "message" => "All fields are required"]);
        exit;
    }

    //Verify Email 
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["error" => true, "message" => "Invalid email"]);
        exit;
    }

    //Check if passwords match
    if ($password !== $confirm_password) {
        echo json_encode(["error" => true, "message" => "Passwords do not match"]);
        exit;
    }

    //Check existing email
    $stmt = $db->prepare("SELECT id FROM $table WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    //if DB conn fails, users gets generic message
    if (!$stmt) {
        echo json_encode(["error" => true, "message" => "Server error"]);
        exit;
    }

    if ($stmt->num_rows > 0) {
        echo json_encode(["error" => true, "message" => "Email already exists"]);
        exit;
    }

    //Encrypt password 
    $password = password_hash($password, PASSWORD_DEFAULT);

    //Store firstname & lastname as name to insert in the DB
    $name = "$firstname $lastname";

    //save into database
    $insert_query = $db->prepare("INSERT INTO $table (name, email, password, role) VALUES (?,?,?,?)");
    $insert_query->bind_param("ssss", $name, $email, $password, $role);

    if ($insert_query->execute()) {
        echo json_encode(["error" => false, "message" => "Account created successfully."]);
    } else {
        echo json_encode(["error" => true, "message" => "Unable to create account."]);
    }
    exit;
}

//LOGIN AUTH

if (isset($_POST["trigger_signin"])) {
    $email = strtolower(trim($_POST["email"] ?? ""));
    $password = $_POST["password"] ?? "";


    //Check if the input field has value
    if (empty($email) || empty($password)) {
        echo json_encode(["error" => true, "message" => "Email or password cannot be empty"]);
        exit;
    }

    //Validate user by checking the database if these credentials exists, else add user
    $stmt = $db->prepare("SELECT id,name,email,password,role FROM $table WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(["error" => true, "message" => "Invalid Credentials"]);
        exit;
    }
    //check the rows to check if these attributes exists!
    $row = $result->fetch_assoc();

    if (password_verify($password, $row["password"])) {

        $_SESSION["user"] = $row["id"];
        $_SESSION["id"] = $row["id"];
        $_SESSION["name"] = $row["name"];
        $_SESSION["email"] = $row["email"];
        $_SESSION["role"] = $row["role"];

        $redirect = ($row["role"] === "admin") ? "./dashboard/overview" : "./home";

        echo json_encode([
        "error" => false,
        "message" => "Welcome back " . $row["name"],
        "redirect" => $redirect
    ]);
    exit;
       
    } else {
        echo json_encode(["error" => true, "message" => "Invalid Credentials"]);
        exit;
    }
}

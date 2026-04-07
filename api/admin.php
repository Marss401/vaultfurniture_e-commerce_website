<?php
$folder = $_SERVER['DOCUMENT_ROOT'] . "/vaultfurniture";
require_once("$folder/config/db.php");
$table = "users";

if(isset($_POST["trigger_delete"])){
    $userId = $_POST["deleteId"];
    $delete_query = $db->query("DELETE FROM $table WHERE id = '$userId' ");
    if($delete_query){
        echo json_encode(["error" => false, "message" => "Admin deleted successfully"]);
    }
    else{
        echo json_encode(["error"=> true, "message"=> "Unable to delete admin"]);
    }
}

if(isset($_POST["trigger_edit"])){
    $id = $_POST["trigger_edit"];
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $email = strtolower($email);
    $role = $_POST["role"];

    $save_query = $db->query("UPDATE $table SET name='$fullname', email='$email', role='$role' WHERE id='$id' ");
    if($save_query){
        echo json_encode(["error" => false, "message" => "Admin saved successfully"]);
    }
    else{
        echo json_encode(["error"=> true, "message"=> "Unable to save Admin"]);
    }

}
<?php
session_start();
// Include database connection
require_once __DIR__ . '/../config/db.php';
$table = 'categories';

//Category table 
if(isset($_POST['action']) && $_POST['action'] === "create") {
  $category_name = $_POST['name']; //name of the category is sent to the database to create a new category

  try {

    $users_id = $_SESSION['id']; //Verifies if the user is authorised to make this request, if yes, proceed
    //save into db
    $stmt = $db->prepare("INSERT INTO $table (name) VALUES (?)");
    $stmt->bind_param('s', $category_name);
    $stmt->execute();

    echo json_encode(['error' => false, 'message' => 'New Category created']);
  } catch (\Throwable $th) {
    //throw $th;
    echo json_encode(['error' => true, 'Message' => "Unable to create Category. Due to $th"]);
  }
}

//Update Category Table
if(isset($_POST['action']) && $_POST['action'] === "update"){

    //Fetch these details if Category exists and update
    $id = $_POST['id'];
    $name = $_POST['name'];

    try {
        $stmt = $db->prepare("UPDATE $table SET name=? WHERE id=?");
        $stmt->bind_param("si", $name, $id);
        $stmt->execute();

        echo json_encode([
            "error" => false,
            "message" => "Category updated successfully"
        ]);
    } catch (\Throwable $th) {
        echo json_encode([
            "error" => true,
            "message" => "Unable to update category. Due to $th"
        ]);
    }
}
//Delete a Category Table
if(isset($_POST["trigger_delete"])){
    $userId = $_POST["deleteId"];
    $delete_query = $db->query("DELETE FROM $table WHERE id = '$userId' ");
    if($delete_query){
        echo json_encode(["error" => false, "message" => "Category deleted successfully"]);
    }
    else{
        echo json_encode(["error"=> true, "message"=> "Unable to delete Category"]);
    }
}
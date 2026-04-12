<?php
session_start();
require_once __DIR__ . '/../config/db.php';
$table = 'products';

if (isset($_POST['action'])) {

    $action = $_POST['action'];

    $product_name = $_POST['name'];
    $price = $_POST['price'];
    $qty_available = $_POST['qty_available'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $category = $_POST['category'];
    $users_id = $_SESSION['id'];

    // default image 
    $image_name = isset($_POST['old_image']) ? $_POST['old_image'] : null;

    // if a new image is uploaded (for edit case)
    if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {

        $image = $_FILES['image'];
        $filename = strtolower(pathinfo($image['name'], PATHINFO_BASENAME));
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $valid_extensions = ['jpg', 'jpeg', 'png'];

        if (!in_array($extension, $valid_extensions)) {
            echo json_encode([
                'error' => true,
                'message' => 'Only jpg, jpeg and png are allowed.'
            ]);
            exit();
        }

        // move uploaded file
        $file_path = "../assets/images/products/$filename";
        move_uploaded_file($image['tmp_name'], $file_path);

        $image_name = $filename;
    }

    try {
        if ($action === 'update') {
            $id = $_POST['id'];
            $stmt = $db->prepare("UPDATE $table SET name=?, price=?, qty_available=?, status=?, description=?, image=?, category_id=? WHERE id=?");
            $stmt->bind_param('siisssii', $product_name, $price, $qty_available, $status, $description, $image_name, $category, $id);
            $stmt->execute();

            echo json_encode(['error' => false, 'message' => 'Product updated successfully']);

        } else if ($action === 'create') {
            $stmt = $db->prepare("INSERT INTO $table (name, price, qty_available, status, description, image, category_id, user_id) VALUES (?,?,?,?,?,?,?,?)");
            $stmt->bind_param('siissssi', $product_name, $price, $qty_available, $status, $description, $image_name, $category, $users_id);
            $stmt->execute();

            echo json_encode(['error' => false, 'message' => 'New Product created']);
        }
    } catch (\Throwable $th) {
        echo json_encode(['error' => true, 'message' => "Unable to save Product. $th"]);
    }
}
if(isset($_POST["trigger_delete"])){
    $userId = $_POST["deleteId"];
    $delete_query = $db->query("DELETE FROM $table WHERE id = '$userId' ");
    if($delete_query){
        echo json_encode(["error" => false, "message" => "Product deleted successfully"]);
    }
    else{
        echo json_encode(["error"=> true, "message"=> "Unable to delete Product"]);
    }
}
<?php
session_start();
$folder = $_SERVER['DOCUMENT_ROOT'] . '/vaultfurniture';
require_once("$folder/config/db.php");
$table = 'orders';
$order_items = 'order_items';

if (isset($_POST['trigger_order'])) {
    $location = $_POST['location'];
    $cartItems = $_POST['cartItems'];
    // var_dump($cartItems);
    $cartItems = json_decode($cartItems, true);
    // json_encode() equivalent of JSON.stringify() in Javascript
    // json_decode() equivalent of JSON.parse() in Javascript
    $user_id = $_SESSION['id']; // currently loggedin/active user (the person making the order)

    $db->autocommit(false); // start transaction
    try {
        // Start a Transaction: A transaction is a series of events that must happen together or fail together
        // TODO:    1. Create a record in the orders table and enter the details of the user/location
        //          2. Get the ID of the order in step 1 above
        //          2. Use the content of cartItems to create a record for each item in the order_items table, 
        //             and map it to the id from step 2 
        $order_id = uniqid("EMKT", false);

        $create_order = $db->query("INSERT INTO $table (id, user_id, location) VALUES ('$order_id', '$user_id', '$location')"); // step 1
        if (!$create_order) {
            die($db->error);
        }
        // $order_id = $db->insert_id; // step 2

        foreach ($cartItems as $item) {
            // Loop through each cart item to save in the order_item table
            // var_dump($item);
            $item_id = uniqid("EMKTOD", false);
            $product_id = $item['id'];
            $price = $item['price'];
            $qty = $item['qty'];
            $create_order_item = $db->query("INSERT INTO $order_items (id, order_id, product_id, price, quantity) VALUES ('$item_id', '$order_id', '$product_id', $price, $qty)");
            if (!$create_order_item) {
                die($db->error);
            }
            // Reduce the qty ordered from the qty_available of the product (using the UPDATE QUERY)
            // $update_product_qty_available = $db->query("UPDATE product SET ")
        }
        $db->commit(); // end/save transaction
        echo json_encode(['error' => false, 'message' => "Your order has been successfully received. Order ID is $order_id"]);
    } catch (\Throwable $th) {
        $db->rollback();
        echo json_encode(['error' => true, 'message' => "Unable to process your order. Due to $th"]);
    }
}

if (isset($_POST['trigger_status'])) {
    $id = $db->real_escape_string($_POST['orderId']);
    $status = $db->real_escape_string($_POST['status']);

    $update_query = $db->query("UPDATE $table SET status = '$status' WHERE id = '$id'");
    if ($update_query) {
        // Send email to user
        echo json_encode(['error' => false, 'message' => "Order successfully updated to $status"]);
    } else {
        echo json_encode(['error' => true, 'message' => "Unable to update your order."]);
    }
}

if(isset($_POST["trigger_delete"])){
    $userId = $_POST["deleteId"];
    $delete_query = $db->query("DELETE FROM $table WHERE id = '$userId' ");
    if($delete_query){
        echo json_encode(["error" => false, "message" => "Order deleted successfully"]);
    }
    else{
        echo json_encode(["error"=> true, "message"=> "Unable to delete order"]);
    }
}

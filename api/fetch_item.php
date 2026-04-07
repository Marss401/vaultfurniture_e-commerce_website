<?php 
session_start();
$folder = $_SERVER[ 'DOCUMENT_ROOT' ] . '/vaultfurniture';
require_once( "$folder/config/db.php" );
$table = 'products';

$category_id = $_POST['category_id'];

if ($category_id == "all") {
    $category_query = "SELECT id, image, name, price FROM $table WHERE status = 'Available' ORDER BY RAND() LIMIT 6";
    $stmt = $db->prepare($category_query);
} else {
    $category_query = "SELECT id, image, name, price FROM $table WHERE category_id = ? AND status = 'Available' LIMIT 6";
    $stmt = $db->prepare($category_query);
    $stmt->bind_param("i", $category_id);
}
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
                    $id = $row["id"];
                    $name = $row["name"];
                    $price = $row["price"];
                    $price = number_format($price, 2);
                    $image = $row["image"];
                    $data = json_encode($row);
                    echo <<<_HTML
                        <div class="bg-primary rounded-3xl shadow-md p-4 w-full sm:max-w-2xl max-w-[360px] mx-auto transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <a href="./single_product.php?id=$id" class="rounded-2xl overflow-hidden bg-gray-100">
                                <img src="./assets/images/products/$image" alt="$name" class="w-full h-80 object-cover object-center">
                            </a>
                            <div class="mt-4 flex justify-between items-center">
                                <div>
                                    <p class="text-lg font-semibold text-gray-900">$name</p>
                                    <p class="text-gray-500">&#8358;$price</p>
                                </div>
                                <button data-product='$data' class="cartBtn w-10 h-10 px-6 md:px-8 rounded-full bg-grey text-white cursor-pointer flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-cart-arrow-down"></i>
                                </button>
                            </div>
                        </div>
_HTML;
                }
?>
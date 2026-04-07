<?php
ob_start();
$folder = $_SERVER['DOCUMENT_ROOT'] . "/vaultfurniture";
require_once("$folder/layout/dash_header.php");
if ($_SESSION['role'] === "user") header("location: ./overview");
ob_end_flush();
?>
<!-- Content Goes Here -->
<div class="bg-white p-6 mx-3 mb-6 rounded-xl border border-gray-200 shadow-sm">

    <!-- Section Header -->
    <div class="flex justify-between items-center gap-4 mb-4">
        <div>
            <h2 class="text-xl md:text-2xl font-semibold text-gray-800">
                Product Overview
            </h2>
            <p class="text-sm text-gray-500">
                Manage products, inventory, and availability.
            </p>
        </div>

        <!-- Add Product Button -->
        <button
            type="button"
            id="createProduct"
            class="flex items-center gap-2 px-4 py-2 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">

            <i class="fa-solid fa-plus"></i>
            New Product
        </button>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto rounded-lg border border-gray-200">

        <table class="min-w-full text-sm">

            <!-- Table Header -->
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">S/N</th>
                    <th class="px-4 py-3 text-left">Product Details</th>
                    <th class="px-4 py-3 text-left">Price</th>
                    <th class="px-4 py-3 text-left whitespace-nowrap">Qty Available</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Creator</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="divide-y divide-gray-100 text-gray-700">
                    <?php
                    $table = "products";
                    $find_query = $db->query("SELECT pd.id AS id, pd.name AS product_name, pd.category_id, image, price, qty_available, status, description, ct.name AS category_name, us.name AS user_name FROM $table pd JOIN categories ct ON pd.category_id = ct.id JOIN users us ON pd.user_id = us.id ORDER BY pd.createdAt DESC");

                    if ($find_query && $find_query->num_rows > 0) {
                        $sn = 0;
                        while ($row = $find_query->fetch_assoc()) {
                            $sn++;
                            $id = $row['id'];
                            $name = $row['product_name'];
                            $category_id = $row['category_id'];
                            $price = $row['price'];
                            $qty_available = $row['qty_available'];
                            $status = $row['status'];
                            $description = $row['description'];
                            $image = $row['image'];
                            $category_name = $row['category_name'];
                            $user_name = $row['user_name'];
                            $data = json_encode($row);

                            echo <<<_HTML
            <tr class="hover:bg-slate-100">
                <td class="text-center">$sn</td>
                <td>
                    <div class="flex items-center gap-2 p-2">
                        <div class="overflow-hidden h-10 w-10 rounded-md relative flex-shrink-0 bg-slate-900 text-xs grid place-items-center">
                            <img src="../assets/images/products/$image" alt="Product $sn" class="absolute left-0 top-0 w-full h-full object-cover object-center">
                        </div>
                        <p class="text-sm md:text-base text-slate-700 whitespace-nowrap font-semibold">$name</p>
                    </div>
                </td>
                <td class="text-center">$price</td>
                <td class="text-center">$qty_available</td>
                <td class="text-center">$status</td>
                <td class="text-center">$user_name</td>
                <td class="text-center">
                    <div class="flex justify-center gap-2 w-full">
                        <button title="Edit" data-products='$data' class="editProductBtn cursor-pointer py-1 px-3 bg-bluish text-primary text-sm rounded-md hover:bg-grey"><i class="fa-solid fa-file-pen"></i></button>
                        <button title="Delete" data-id='$id' data-page="product.php" class="deleteBtn cursor-pointer py-1 px-3 bg-pink-500 text-white text-sm rounded-md hover:bg-pink-600"><i class="fa-solid fa-trash-can"></i></button>
                    </div>
                </td>
            </tr>
_HTML;
                        }
                    } else {
                        echo '<tr><td colspan="7" class="text-center py-4">No products found</td></tr>';
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </div>

    <dialog id="productModal">
        <section style="inset-inline-start: 0; scrollbar-width: none;" class="fixed z-50 top-0 bottom-0 left-0 w-full min-h-screen overflow-y-auto grid place-items-center bg-secondary p-6 backdrop-blur-sm">
            <div id="closeModal" class="absolute top-0 left-0 w-full h-full overflow-y-scroll grid place-items-center p-6">
                <button class="absolute top-4 right-4 text-white text-sm font-semibold bg-pink-600 h-6 w-6 flex justify-center items-center rounded-full">&times;</button>
            </div>
            <form id="productForm" class="relative z-10 space-y-1.5 w-full max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg">
                <h3 id="formTitle" class="text-xl font-semibold text-green-600 pb-2 mb-4 border-b border-slate-300">Create Products</h3>
                <input type="hidden" name="id" id="productId">
                <input type="hidden" name="old_image" id="oldImage">
                <input type="hidden" name="trigger_create" value="1">
                <input type="hidden" name="action" id="productAction" value="create">
                <label for="image" class="relative overflow-hidden h-20 w-20 mx-auto block flex-shrink-0 bg-slate-800 rounded-md"> <img id="imagePreview" src="/profile.png" alt="product_image" class="absolute top-0 left-0 w-full h-full object-cover object-center">
                <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" class="hidden"> </label>
                <div class="relative"> <label for="name" class="text-xs font-semibold text-slate-400">Product Name</label> <input required type="text" name="name" id="name" placeholder="Name e.g. Luxury Chair" class="py-2 px-4 rounded-md border border-slate-300 w-full text-slate-600 text-sm"> </div>
                <div class="relative"> <label for="price" class="text-xs font-semibold text-slate-400">Price</label> <input required type="number" name="price" id="price" min="1" placeholder="Enter Product Price" class="py-2 px-4 rounded-md border border-slate-300 w-full text-slate-600 text-sm"> </div>
                <div class="relative"> <label for="qty_available" class="text-xs font-semibold text-slate-400">Quanity Available for Sale</label> <input required type="number" name="qty_available" id="qty_available" min="1" placeholder="Enter Products Quantity" class="py-2 px-4 rounded-md border border-slate-300 w-full text-slate-600 text-sm"> </div>
                <div class="relative pb-2"> <label for="status" class="text-xs font-semibold text-slate-400">Status</label> <select name="status" id="status" class="py-2 px-4 rounded-md border border-slate-300 w-full text-slate-600 text-sm bg-transparent">
                        <option class="bg-transparent font-sans" value="Available">Available</option>
                        <option class="bg-transparent font-sans" value="Unavailable">Unavailable</option>
                    </select> </div>
                <div class="relative pb-2"> <label for="category" class="text-xs font-semibold text-slate-400">Category</label> <select name="category" id="category" class="py-2 px-4 rounded-md border border-slate-300 w-full text-slate-600 text-sm bg-transparent">
                        <?php $categories = $db->query("SELECT id, name FROM categories");
                        if ($categories->num_rows > 0) {
                            while ($row = $categories->fetch_assoc()) {
                                $id = $row['id'];
                                $name = $row['name'];
                                echo "<option value='$id'>$name</option>";
                            }
                        } else {
                            echo "<option id='0' name='all'>All</option>";
                        } ?>
                    </select>
                </div>
                <div class="relative"> <label for="description" class="text-xs font-semibold text-slate-400">Description</label> <textarea required name="description" id="description" rows="5" placeholder="Enter Quantity description..." class="py-2 px-4 rounded-md border border-slate-300 w-full text-slate-600 text-sm"></textarea> </div>
                <button type="submit" class="py-1 px-4 bg-slate-900 rounded-md text-primary cursor-pointer flex items-center gap-2" id="saveBtn"><i class="fa-solid fa-download"></i> <span class="-mt-1">Save Record</span></button>
            </form>
        </section>
    </dialog>

    <?php
    require_once("$folder/layout/dash_footer.php");
    ?>
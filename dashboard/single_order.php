<?php
ob_start();
$folder = $_SERVER['DOCUMENT_ROOT'] . "/vaultfurniture";
require_once("$folder/layout/dash_header.php");
$id = $_SESSION['id'];
$role = $_SESSION['role'];
$clause = $role === "user" ? "WHERE us.id = $id" : "";
ob_end_flush();
$order_id = $_GET['id'];
?>
<!-- Content Goes Here -->
<div class="bg-white p-6 mx-3 mb-6 rounded-xl border border-gray-200 shadow-sm">

    <!-- Section Header -->
    <div class="flex justify-between items-center gap-4 mb-4">
        <div>
            <h2 class="text-xl md:text-2xl font-semibold text-gray-800">
                Order ID: <?= $order_id ?>
            </h2>
            <p class="text-sm text-gray-500">
                Order details, and more.
            </p>
        </div>
        <!-- Add Order Button -->
        <!-- <button
            type="button"
            id="createProduct"
            class="flex items-center gap-2 px-4 py-2 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">

            <i class="fa-solid fa-plus"></i>
            New Product
        </button> -->
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
                    <th class="px-4 py-3 text-left whitespace-nowrap">Quantity</th>
                    <th class="px-4 py-3 text-left">Total Price</th>
                    <th class="px-4 py-3 text-left whitespace-nowrap">Date Ordered</th>
                    <?= $role === "user" ? "" : '<th class="py-3 px-4 text-left">Actions</th>' ?>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="divide-y divide-gray-100 text-gray-700">
                    <?php
                     $table = "order_items"; 
                     $product_table = "products";

                    $find_query = $db->query("SELECT oi.id, oi.price, oi.quantity, SUM(oi.price * oi.quantity) AS total_price, oi.createdAt, pd.name, pd.image FROM $table oi JOIN $product_table pd ON oi.product_id = pd.id WHERE oi.order_id = '$order_id' GROUP BY oi.id ORDER BY oi.createdAt DESC");
                    if ($find_query && $find_query->num_rows > 0) {
                        $sn = 0;
                        while ($row = $find_query->fetch_assoc()) {
                            $sn++;
                            $id = $row['id'];
                            $price = $row['price'];
                            $price = number_format($price, 2);
                            $qty = $row['quantity'];
                            $total_price = $row['total_price'];
                            $total_price = number_format($total_price, 2);
                            $name = $row['name'];
                            $image = $row['image'];
                            $createdAt = date("D d M, Y", strtotime($row['createdAt']));
                            $action = $role === "user" ? "" : "<td class='text-center'>
                    <div class='flex justify-center gap-2 w-full'>
                        <button title='Delete' data-id='$id' data-page='placeorder.php' class='deleteBtn py-1 px-3 bg-pink-500 text-white text-sm rounded-md hover:bg-pink-600'>Delete</button>
                    </div>
                </td>";

                            echo <<<_HTML
            <tr class="hover:bg-slate-100">
                <td class="text-center min-w-wd truncate">$sn</td>
                <td>
                    <div class="flex items-center gap-2 p-2">
                        <div class="overflow-hidden h-8 w-8 rounded-md relative flex-shrink-0 bg-slate-900 text-xs grid place-items-center">
                            <img src="../assets/images/products/$image" alt="$name" class="absolute left-0 top-0 w-full h-full object-cover object-center">
                        </div>
                        <p class="text-sm text-slate-700 whitespace-nowrap font-semibold">$name</p>
                    </div>
                </td>
                <td class="text-center text-sm min-w-wd max-w-[200px] truncate">&#8358;$price</td>
                <td class="text-center text-sm min-w-wd max-w-[200px] truncate">$qty</td>
                <td class="text-center text-sm min-w-wd max-w-[200px] truncate">&#8358;$total_price</td>
                <td class="text-center">$createdAt</td>
                $action
            </tr>
_HTML;
                        }
                    } else {
                        echo '<tr><td colspan="6" class="text-center py-4">No orders found</td></tr>';
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </div>

    <dialog id="productModal">
        <section style="inset-inline-start: 0; scrollbar-width: none;"
            class="fixed z-50 top-0 bottom-0 left-0 w-full min-h-screen overflow-y-auto grid place-items-center bg-slate-600/50 p-6 backdrop-blur-sm">
            <div id="closeModal"
                class="absolute top-0 left-0 w-full h-full overflow-y-scroll grid place-items-center p-6">
                <button
                    class="absolute top-4 right-4 text-white text-sm font-semibold bg-[#f66] h-6 w-6 flex justify-center items-center rounded-full">&times;</button>
            </div>
            <form id="productForm"
                class="relative z-10 space-y-1.5 w-full max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg">
                <h3 id="formTitle" class="text-xl font-semibold text-green-600 pb-2 mb-4 border-b border-slate-300">Add
                    Product</h3>
                <input type="hidden" name="trigger_create" id="trigger">
                <!-- <label for="image"
                    class="relative overflow-hidden h-20 w-20 mx-auto block flex-shrink-0 bg-slate-800 rounded-md">
                    <img id="imagePreview" src="../assets/images/products/$image" alt="product_image"
                        class="absolute top-0 left-0 w-full h-full object-cover object-center">
                    <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" class="hidden">
                </label> -->
                <div class="relative">
                    <label for="name" class="text-xs font-semibold text-slate-400">Product Name</label>
                    <input required type="text" name="name" id="name" placeholder="Name e.g. Pounded Yam"
                        class="py-2 px-4 rounded-md border border-slate-300 w-full text-slate-600 text-sm">
                </div>
                <div class="relative">
                    <label for="price" class="text-xs font-semibold text-slate-400">Price</label>
                    <input required type="number" name="price" id="price" min="1" placeholder="Enter Product Price"
                        class="py-2 px-4 rounded-md border border-slate-300 w-full text-slate-600 text-sm">
                </div>
                <div class="relative">
                    <label for="qty_available" class="text-xs font-semibold text-slate-400">Quanity Available for
                        Sale</label>
                    <input required type="number" name="qty_available" id="qty_available" min="1"
                        placeholder="Enter Product Price"
                        class="py-2 px-4 rounded-md border border-slate-300 w-full text-slate-600 text-sm">
                </div>
                <div class="relative pb-2">
                    <label for="status" class="text-xs font-semibold text-slate-400">Status</label>
                    <select name="status" id="status"
                        class="py-2 px-4 rounded-md border border-slate-300 w-full text-slate-600 text-sm bg-transparent">
                        <option class="bg-transparent font-sans" value="Available">Available</option>
                        <option class="bg-transparent font-sans" value="Unavailable">Unavailable</option>
                    </select>
                </div>
                <div class="relative">
                    <label for="description" class="text-xs font-semibold text-slate-400">Description</label>
                    <textarea required name="description" id="description" rows="5"
                        placeholder="Enter Product description..."
                        class="py-2 px-4 rounded-md border border-slate-300 w-full text-slate-600 text-sm"></textarea>
                </div>
                <button type="submit"
                    class="py-1 px-4 bg-slate-900 rounded-md text-white cursor-pointer flex items-center gap-2"
                    id="saveBtn"><i class="ri-newspaper-line"></i> <span class="-mt-1">Save Record</span></button>
            </form>
        </section>
    </dialog>

    <?php
    require_once("$folder/layout/dash_footer.php");
    ?>
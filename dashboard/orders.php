<?php
ob_start();
$folder = $_SERVER['DOCUMENT_ROOT'] . "/vaultfurniture";
require_once("$folder/layout/dash_header.php");
$id = $_SESSION['id'];
$role = $_SESSION['role'];
$clause = $role === "user" ? "WHERE us.id = $id" : "";
ob_end_flush();
echo $id;
echo $role;
?>
<!-- Content Goes Here -->
<div class="bg-white p-6 mx-3 mb-6 rounded-xl border border-gray-200 shadow-sm">

    <!-- Section Header -->
    <div class="flex justify-between items-center gap-4 mb-4">
        <div>
            <h2 class="text-xl md:text-2xl font-semibold text-gray-800">
                Order Overview
            </h2>
            <p class="text-sm text-gray-500">
                View and manage your order details, and more.
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
                    <th class="px-4 py-3 text-left">Order ID</th>
                    <th class="px-4 py-3 text-left">Order Details</th>
                    <th class="px-4 py-3 text-left">Price</th>
                    <th class="px-4 py-3 text-left whitespace-nowrap">User Details</th>
                    <th class="px-4 py-3 text-left">Destination</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left whitespace-nowrap">Date Ordered</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="divide-y divide-gray-100 text-gray-700">
                <?php
                $table = "orders";
                $user_table = "users";
                $order_items = "order_items";
                $product_table = "products";
                $find_query = $db->query("SELECT GROUP_CONCAT(pd.image) AS product_images, GROUP_CONCAT(pd.name) AS product_names, od.id AS order_id, od.location AS order_destination, od.status AS order_status, od.createdAt AS order_date, SUM(oi.price * oi.quantity) AS total_price, COUNT(oi.id) AS total_orders, us.name AS user_name, us.email AS user_email FROM $table od JOIN $order_items oi ON od.id = oi.order_id JOIN $product_table pd ON oi.product_id = pd.id JOIN $user_table us ON od.user_id = us.id $clause GROUP BY od.id ORDER BY od.createdAt DESC");

                if ($find_query && $find_query->num_rows > 0) {
                    $sn = 0;
                    while ($row = $find_query->fetch_assoc()) {
                        $all_images = "";
                        $sn++;
                        $order_id = $row['order_id'];
                        $total_price = $row['total_price'];
                        $total_price = number_format($total_price, 2);
                        $total_orders = $row['total_orders'];
                        $user_name = $row['user_name'];
                        $user_email = $row['user_email'];
                        $order_status = $row['order_status'];
                        $order_destination = $row['order_destination'];
                        $order_date = date("D d M, Y", strtotime($row['order_date']));
                        $product_names = explode(",", $row['product_names']);
                        $product_images = explode(",", $row['product_images']);
                        $data = json_encode($row);
                        for ($i = 0; $i < count($product_images); $i++) {
                            $value = $i + 2;
                            $image = $product_images[$i];
                            $product_name = $product_names[$i];
                            $all_images .= "<div class='relative group w-max'> 
                                    <div class='h-5 w-5 sm:h-7 sm:w-7 relative overflow-hidden rounded-full bg-slate-800 flex justify-center items-center -ml-2 cursor-pointer border-2 border-slate-200 z-[$value] hover:z-30'>
                                        <img src='../assets/images/products/$image' alt='$image' class='absolute left-0 top-0 w-full h-full object-cover object-center'>
                                    </div>
                                    <p class='group-hover:z-30 hidden group-hover:flex whitespace-nowrap absolute bg-gray-800 text-white text-xs font-semibold px-2 py-1 rounded-full bottom-[110%] left-1/2 -translate-x-1/2'>$product_name</p>
                                </div>
                                ";
                        }
                        $action = $role === "user" ? "<td class='text-center'>
                    <div class='flex justify-center gap-2 w-full'>
                        <button title='View Order' data-order='$data' class='viewOrderBtn cursor-pointer py-1 px-3 bg-green-100/70 text-green-700 hover:bg-green-200 text-sm rounded-md'>View Order</button>
                    </div>
                </td>" : "<td class='text-center'>
                    <div class='flex justify-center gap-2 w-full'>
                        <button title='View Order' data-order='$data' class='viewOrderBtn cursor-pointer py-1 px-3 bg-green-100/70 text-green-700 hover:bg-green-200 text-sm rounded-md'>Edit</button>
                        <button title='Delete Order' data-id='$id' data-page='placeorder.php' class='deleteBtn cursor-pointer py-1 px-3 bg-pink-500 text-white text-sm rounded-md hover:bg-pink-600'>Delete</button>
                    </div>
                </td>";
                        // HEREDOC
                        echo <<<_HTML
            <tr class="hover:bg-slate-100 text-sm">
                <td class="text-center">
                    <a class="hover:underline p-2 flex items-center gap-2" href="./single_order.php?id=$order_id">
                        <p class="flex justify-start px-2 text-xs font-bold">$order_id</p>
                    </a>
                </td>
                <td class="text-center">
                    <a class="p-2 flex justify-center items-center gap-2 w-full" href="./single_order.php?id=$order_id">
                        <div class="flex justify-center">$all_images</div>
                    </a>
                </td>
                <td class="text-center min-w-wd truncate">&#8358;$total_price</td>
                <td>
                    <p class="text-sm text-slate-700 whitespace-nowrap font-semibold">$user_name</p>
                </td>
                <td title="$order_destination" class="text-left min-w-wd">
                    <div class="group relative w-max">
                        <div class="flex gap-2 items-center max-w-[200px] truncate">
                            <i class="ri-map-pin-user-line flex-shrink-0 text-primary"></i> $order_destination
                        </div>
                        <p class='group-hover:z-30 hidden group-hover:flex whitespace-nowrap absolute bg-slate-900 text-white text-xs font-semibold px-2 py-1 rounded-full top-0 left-1/2 -translate-x-1/2'>$order_destination</p>
                    </div>
                </td>
                <td class="text-center">
                <div class="flex gap-2 items-center">
                    $order_status
                </div>
                </td>
                <td class="text-center">$order_date</td>
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

<dialog id="orderModal">
    <section
        class="fixed z-50 top-0 left-0 w-full h-screen overflow-y-scroll grid place-items-center bg-slate-600/50 p-6 backdrop-blur-sm">
        <div id="closeModal" class="absolute top-0 left-0 w-full h-screen overflow-y-scroll grid place-items-center bg-slate-600/50 p-6 backdrop-blur-sm">
            <button class="absolute top-4 right-4 text-white text-sm font-semibold bg-[#f66] h-6 w-6 flex justify-center items-center rounded-full">&times;</button>
        </div>
        <form id="orderForm" class="relative z-10 space-y-1.5 w-full max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-center gap-2 mb-4 border-b border-slate-300">
                <h3 id="formTitle" class="text-xl font-semibold text-green-600 pb-2">Order Information</h3>
                <div id="order_status" class="px-2 py-0.5 rounded-md w-max bg-slate-500 text-white text-xs font-semibold">Pending</div>
            </div>
            <div class="orderContainer">

            </div>
            <?php
            echo $role !== "user" ?
                '<div class="relative pb-2 px-1 pt-0 -translate-y-2">
                        <label for="status" class="text-xs font-semibold text-slate-400 pb-2">Change Order Status</label>
                        <select name="status" id="status" class="py-2 px-4 rounded-md border border-slate-300 w-full text-slate-600 text-sm bg-transparent">
                            <option class="bg-transparent font-sans" value="Pending">Pending</option>
                            <option class="bg-transparent font-sans" value="Received">Received</option>
                            <option class="bg-transparent font-sans" value="Out for Delivery">Out for Delivery</option>
                            <option class="bg-transparent font-sans" value="Delivered">Delivered</option>
                            <option class="bg-transparent font-sans" value="Returned">Returned</option>
                        </select>
                    </div>
                    <button type="submit" class="py-1 px-4 mx-1 bg-secondary rounded-md text-white cursor-pointer flex items-center gap-2" id="saveBtn"><i class="ri-receipt-line"></i> <span class="-mt-1 text-sm">Change Status</span></button>
                    ' : "";
            ?>
        </form>
    </section>
</dialog>

<?php
require_once("$folder/layout/dash_footer.php");
?>
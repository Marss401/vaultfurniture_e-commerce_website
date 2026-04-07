<?php 
$folder = $_SERVER['DOCUMENT_ROOT'] . "/vaultfurniture";
require_once("$folder/layout/dash_header.php");
$product_query = $db->query("SELECT COUNT(id) AS total, status FROM products GROUP BY status ORDER BY status ASC")->fetch_assoc();
$available = $product_query['total'];
?>
<div class="bg-gray-50 pt-4 mx-3 rounded-md -mt-6 mb-6 shadow-lg shadow-gray-300">
  <div class="container mx-auto grid sm:grid-cols-2 md:grid-cols-4 gap-4 md:gap-8 py-4">

    <!-- Total Products -->
    <aside class="bg-white rounded-md shadow-lg flex flex-col justify-between overflow-hidden border-l-4 border-green-400">
      <div class="flex items-center gap-4 p-3">
        <div class="h-12 w-12 rounded-md bg-green-100 text-green-600 text-2xl grid place-items-center">
          <i class="fa-solid fa-box"></i>
        </div>
        <div class="flex-1 text-right">
          <p class="text-xs text-gray-500 font-semibold">Total Products</p>
          <h4 class="text-xl text-green-600 font-bold tracking-tight mt-1.5">18</h4>
        </div>
      </div>
      <p class="bg-green-50 flex justify-between gap-4 text-xs text-green-700 font-semibold tracking-tight p-2 px-4 border-t border-green-100">
        <span>15 Available</span> 3 Unavailable
      </p>
    </aside>

    <!-- Total Sales -->
    <aside class="bg-white rounded-md shadow-lg flex flex-col justify-between overflow-hidden border-l-4 border-pink-400">
      <div class="flex items-center gap-4 p-3">
        <div class="h-12 w-12 rounded-md bg-pink-100 text-pink-600 text-2xl grid place-items-center">
          <i class="fa-solid fa-wallet"></i>
        </div>
        <div class="flex-1 text-right">
          <p class="text-xs text-gray-500 font-semibold">Total Sales</p>
          <h4 class="text-xl text-pink-600 font-bold tracking-tight mt-1.5">&#8358;218,000</h4>
        </div>
      </div>
      <p class="bg-pink-50 text-xs text-pink-700 font-semibold tracking-tight p-2 px-4 border-t border-pink-100">
        <strong>&#8358;150,000</strong> made this year
      </p>
    </aside>

    <!-- Total Orders -->
    <aside class="bg-white rounded-md shadow-lg flex flex-col justify-between overflow-hidden border-l-4 border-indigo-400">
      <div class="flex items-center gap-4 p-3">
        <div class="h-12 w-12 rounded-md bg-indigo-100 text-indigo-600 text-2xl grid place-items-center">
          <i class="fa-solid fa-shopping-cart"></i>
        </div>
        <div class="flex-1 text-right">
          <p class="text-xs text-gray-500 font-semibold">Total Orders</p>
          <h4 class="text-xl text-indigo-600 font-bold tracking-tight mt-1.5">10</h4>
        </div>
      </div>
      <p class="bg-indigo-50 flex justify-between gap-4 text-xs text-indigo-700 font-semibold tracking-tight p-2 px-4 border-t border-indigo-100">
        <span>6 Delivered</span> 4 Pending
      </p>
    </aside>

    <!-- Total Users -->
    <aside class="bg-white rounded-md shadow-lg flex flex-col justify-between overflow-hidden border-l-4 border-sky-400">
      <div class="flex items-center gap-4 p-3">
        <div class="h-12 w-12 rounded-md bg-sky-100 text-sky-600 text-2xl grid place-items-center">
          <i class="fa-solid fa-users"></i>
        </div>
        <div class="flex-1 text-right">
          <p class="text-xs text-gray-500 font-semibold">Total Users</p>
          <h4 class="text-xl text-sky-600 font-bold tracking-tight mt-1.5">5</h4>
        </div>
      </div>
      <p class="bg-sky-50 flex justify-between gap-4 text-xs text-sky-700 font-semibold tracking-tight p-2 px-4 border-t border-sky-100">
        <span>2 Admins</span> 3 Customers
      </p>
    </aside>

  </div>
</div>

<?php
require_once("$folder/layout/dash_footer.php");

?>
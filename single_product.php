<?php
define('BASE_URL', '');
require_once("./layout/header.php");
$table = "products";
$data = "";
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $result = $db->query("SELECT id, name, price, image, qty_available, description FROM $table WHERE id = '$product_id'");
    $result->num_rows > 0;
    while ($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $name = $row["name"];
        $price = $row["price"];
        $price = number_format($price, 2);
        $image = $row["image"];
        $qty_available = $row['qty_available'];
        $description = $row['description'];
        $data = json_encode($row);
        echo <<<_HTML
        <main class="relative">
        <section class="bg-tertiary relative py-10 md:py-20 px-4">
            <img src="./assets/images/products/$image" alt="$name" class="absolute top-0 left-0 w-full h-full opacity-20 object-cover">
            <div class="container relative mx-auto space-y-6">
            <div class="text-center space-y-3">
                <h3 class="text-2xl md:text-4xl text-green-50 font-bold">$name Info</h3>
                <p class="text-slate-50 text-base max-w-lg mx-auto flex gap-2 items-center justify-center">
                <a href="./" class="text-sm md:text-base text-white p-1">Home</a>
                <i class="fa-solid fa-angle-right"></i>
                <a href="./store" class="text-sm md:text-base text-white/70 p-1">Product</a>
                </p>
            </div>
            </div>
        </section>
        <section class="py-10 bg-white px-4">
        <div class="container mx-auto grid md:grid-cols-2 gap-4 md:gap-6">
        <figure class="bg-white shadow-xl rounded-md relative min-h-68 md:h-120 w-150 overflow-hidden">
          <img src="./assets/images/products/$image" alt="$name" class="absolute top-0 left-0 w-full h-full object-cover">
        </figure>
        <div class="flex flex-col justify-center py-5 md:py-20">
          <h3 class="text-2xl md:text-4xl text-orange-500 font-bold py-2">$name</h3>
          <p class="text-sm md:text-base text-slate-500 leading-snug max-w-xl pt-3 pb-5">$description</p>
          <p class="text-slate-600 text-xl mb-4">&#8358;$price</p>
          <div class="flex gap-2 mb-4 btnContainer">
            <button class="cartMinus h-8 w-8 rounded-md grid place-items-center cursor-pointer text-slate-500 bg-primary hover:bg-gray-200 hover:text-white text-lg border border-gray-300">-</button>
            <div class="overflow-hidden w-10 border border-slate-300 rounded-md">
              <input data-id='$id' onchange="handleCartChange(this, '$id')" type="number" name="qty" id="qty" min="1" max="$qty_available" value="1" class="cartQty input_qty h-8 w-16 pl-2.5 rounded-md bg-white outline-none text-slate-500">
            </div>
            <button class="cartPlus h-8 w-8 rounded-md grid place-items-center cursor-pointer text-slate-500 bg-primary hover:bg-gray-200 hover:text-white text-lg border border-gray-300">+</button>
          </div>
          <button data-product='$data' class="cartBtn cartSingleBtn w-max h-8 px-6 md:px-8 rounded-md bg-grey text-white cursor-pointer flex items-center gap-2">
         <i class="fa-solid fa-cart-arrow-down"></i> Add to Cart
          </button>
        </div>
      </div>
  </section>
</main>
<script>
window.onload = () => {
  toggleCartBtnVisibility('$id')
}
</script>
_HTML;
    }
} else {
    echo "Something went wrong";
    exit;
}
?>
<?php
    require_once("./layout/footer.php");
?>


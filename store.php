<?php
define('BASE_URL', '');
require_once("./layout/header.php");
if (!isset($_SESSION["id"])) {
    header("Location: signin");
    exit;
}
?>
<main class="relative bg-primary">
    <section class="px-4 py-6 md:py-10">
        <div class="container mx-auto">
            <div div class="text-center">
                <h3 class="font-semibold text-lg md:text-2xl text-dark-text text-center">Our Collections</h3>
            </div>
             <div id="products-container" class="pt-8 md:pt-12 grid grid-cols-2 md:grid-cols-3 gap-5 md:gap-6">
                <?php
                $table = "products";
                $category_query = $db->query("SELECT id, image, name, price FROM $table WHERE status = 'Available' ORDER BY createdAt DESC");
                while ($row = $category_query->fetch_assoc()) {
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
            </div>
        </div>
    </section>
</main>
<?php
    require_once("./layout/footer.php");
?>
<?php
define('BASE_URL', '');
require_once("./layout/header.php");
?>
<main>
    <section>
        <div>
            <div>

            </div>
            <div id="products-container" class="pt-8 md:pt-12 grid grid-cols-2 md:grid-cols-3 gap-5 md:gap-6">
                <?php
                $search = $_GET['search'] ?? '';
                $category = $_GET['category'] ?? 'all';

                $sql = "SELECT * FROM products WHERE status='Available'";

                $params = [];
                $types = "";

                if (!empty($search)) {
                    $sql .= " AND name LIKE ?";
                    $params[] = "%$search%";
                    $types .= "s";
                }

                if ($category !== "all") {
                    $sql .= " AND category_id = ?";
                    $params[] = $category;
                    $types .= "i";
                }

                $stmt = $db->prepare($sql);

                if (!empty($params)) {
                    $stmt->bind_param($types, ...$params);
                }

                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id = $row["id"];
                        $name = $row["name"];
                        $price = $row["price"];
                        $price = number_format($price, 2);
                        $image = $row["image"];
                        $data = json_encode($row);
                        echo <<<_HTML
                        <div class="product-card bg-primary rounded-3xl shadow-md p-4 w-full sm:max-w-2xl max-w-[360px] mx-auto transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <h3 class="text-2xl p-2 text-grey inline-block"><strong>$search</strong></h3>
                            <a href="" class="rounded-2xl overflow-hidden bg-gray-100">
                                <img src="./assets/images/products/$image" alt="$name" class="w-full h-80 object-cover">
                            </a>
                             <div class="mt-4 flex justify-between items-center">
                            <div>
                                <p class="text-lg font-semibold text-gray-900">$name</p>
                                <p class="text-gray-500">&#8358;$price</p>
                            </div>
                           <button data-product='$data' class="cardBtn bg-dark-text h-10 w-10 flex items-center justify-center text-primary rounded-full cursor-pointer"><i class="fa-solid fa-arrow-up-right-from-square"></i></button>
                        </div>
                        </div>
_HTML;
                    }
                } else {

                    echo "<p class='text-center text-gray-500'>No product found</p>";
                }

                ?>
            </div>
        </div>
    </section>
</main>

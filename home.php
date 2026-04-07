<?php
define('BASE_URL', '');
require_once("./layout/header.php");
?>

<main class="relative bg-primary">
    <section class="px-4 py-6 md:py-10">
        <div class="container mx-auto">
            <div class="text-center">
                <h1 class="text-dark-text text-3xl md:text-6xl font-bold tracking-wide leading-tight">Transform <span class="inline-block h-16 w-16 rounded-2xl overflow-hidden align-middle"><img src="assets/images/sofa-chair-black.jpg" alt="text-image1" class="h-full w-full object-cover object-center"></span> Space with <br>
                    <span class="inline-block h-16 w-42 rounded-4xl overflow-hidden align-middle"><img src="assets/images/sofa-living-room-orange.jpg" alt="text_image2" class="w-full h-full object-cover object-bottom"></span> Suitable Furniture
                </h1>
            </div>
            <div class="max-w-6xl items-start my-4 mx-auto grid gap-6 lg:grid-cols-3">

                <!-- HERO CARD -->
                <div class="lg:col-span-2 relative overflow-hidden shadow-lg
                rounded-tr-3xl rounded-bl-3xl
                rounded-tl-[60px] rounded-br-[60px]">

                    <img
                        src="assets/images/sofa-living-room-main.jpg"
                        class="w-full h-[360px] md:h-[550px] object-cover transition-transform duration-500 hover:scale-105" />

                    <!-- Glass Review Badge -->
                    <div class="absolute top-6 left-6 flex items-center gap-3
                  bg-primary backdrop-blur-md border border-white/40
                  px-4 py-2 rounded-full shadow-lg">

                        <div class="flex -space-x-2">
                            <img class="w-7 h-7 rounded-full border" src="https://i.pravatar.cc/40?img=1">
                            <img class="w-7 h-7 rounded-full border" src="https://i.pravatar.cc/40?img=2">
                            <img class="w-7 h-7 rounded-full border" src="https://i.pravatar.cc/40?img=3">
                        </div>

                        <span class="text-sm font-medium text-dark-text">
                            Check reviews
                        </span>
                    </div>

                    <!-- CTA -->
                    <div class="absolute gap-2 flex items-center justify-center bottom-6 right-6
                     bg-black text-white px-6 py-3 rounded-full
                     shadow-lg transition-all duration-300
                     hover:bg-gray-800 hover:scale-105">
                        Shop Now
                        <span class="bg-primary h-8 w-8 flex items-center justify-center text-dark-text rounded-full"><i class="fa-solid fa-arrow-up-right-from-square"></i></span>
                    </div>
                </div>

                <!-- PRODUCT LIST -->
                <div class="flex flex-col gap-6 w-full">

                    <!-- Product Card -->
                    <div class="bg-primary rounded-3xl shadow-md p-4 w-full sm:max-w-2xl max-w-[360px] mx-auto
              transition-all duration-300 hover:shadow-xl hover:-translate-y-1">

                        <div class="rounded-2xl overflow-hidden bg-gray-100">
                            <img src="assets/images/chair-2.jpeg"
                                class="w-full h-40 object-cover">
                        </div>

                        <div class="mt-4 flex justify-between items-center">
                            <div>
                                <p class="text-lg font-semibold text-gray-900">Elite Sofa</p>
                                <p class="text-gray-500">$126.00</p>
                            </div>
                            <button data-product='$data' class="cardBtn bg-dark-text h-10 w-10 flex items-center justify-center text-primary rounded-full cursor-pointer"><i class="fa-solid fa-arrow-up-right-from-square"></i></button>
                        </div>

                    </div>

                    <!-- Product Card -->
                    <div class="bg-white rounded-3xl shadow-md p-4 w-full sm:max-w-2xl max-w-[360px] mx-auto
              transition-all duration-300 hover:shadow-xl hover:-translate-y-1">

                        <div class="rounded-2xl overflow-hidden bg-gray-100">
                            <img src="assets/images/sofa-living-room-main.jpg"
                                class="w-full h-40 object-cover">
                        </div>

                        <div class="mt-4 flex justify-between items-center">
                            <div>
                                <p class="text-lg font-semibold text-gray-900">Elite Sofa</p>
                                <p class="text-gray-500">$240.00</p>
                            </div>
                            <button data-product='$data' class="cardBtn bg-dark-text h-10 w-10 flex items-center justify-center text-primary rounded-full cursor-pointer"><i class="fa-solid fa-arrow-up-right-from-square"></i></button>
                        </div>

                    </div>

                </div>


            </div>
        </div>
    </section>
    <section class="px-4 py-6 md:py-10">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-gray-100">
                <div class="flex flex-col items-center text-center py-4">
                    <h1 class="font-extrabold text-4xl mb-3 text-dark-text">18K+</h1>
                    <p class="text-secondary font-light text-sm">Happy and Loyal Customers buy <br>our products.</p>
                </div>
                <div class="flex flex-col items-center text-center py-4">
                    <h1 class="font-extrabold text-4xl mb-3 text-dark-text">700+</h1>
                    <p class="text-secondary font-light text-sm">Products that we have created <br>and sold in the market.</p>
                </div>
                <div class="flex flex-col items-center text-center py-4">
                    <h1 class="font-extrabold text-4xl mb-3 text-dark-text">95%</h1>
                    <p class="text-secondary font-light text-sm">Customers who have purchased <br>and came back.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="px-4 py-6 mb:py-10">
        <div class="container mx-auto">
            <div>
                <h1 class="text-dark-text font-bold text-3xl md:text-4xl text-center tracking-wide">Our Best Quality Products</h1>
                <div class="flex flex-wrap items-center justify-center gap-3 py-4">

                    <button class="filter-btn active px-4 py-2 rounded-full border border-slate-300
                 bg-slate-900 text-white font-medium
                 hover:bg-slate-800 transition"
                        data-category="all">
                        All
                    </button>

                    <button class="filter-btn px-4 py-2 rounded-full border border-slate-300
                 text-slate-700 hover:bg-slate-100 transition"
                        data-category="1">
                        Chair
                    </button>

                    <button class="filter-btn px-4 py-2 rounded-full border border-slate-300
                 text-slate-700 hover:bg-slate-100 transition"
                        data-category="5">
                        Cabinet
                    </button>

                    <button class="filter-btn px-4 py-2 rounded-full border border-slate-300
                 text-slate-700 hover:bg-slate-100 transition"
                        data-category="2">
                        Sofa
                    </button>

                    <button class="filter-btn px-4 py-2 rounded-full border border-slate-300
                 text-slate-700 hover:bg-slate-100 transition"
                        data-category="3">
                        Bed
                    </button>

                </div>
            </div>
            <div id="products-container" class="pt-8 md:pt-12 grid grid-cols-2 md:grid-cols-3 gap-5 md:gap-6">
                <?php
                $table = "products";
                $category_query = $db->query("SELECT id, image, name, price FROM $table WHERE status = 'Available' ORDER BY RAND() LIMIT 6");
                while ($row = $category_query->fetch_assoc()) {
                    $id = $row["id"];
                    $name = $row["name"];
                    $price = $row["price"];
                    $price = number_format($price, 2);
                    $image = $row["image"];
                    $data = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
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
            <div class="text-right mt-6">
                <a href="./store.php"
                    class="inline-flex items-center justify-center px-6 py-3 rounded-full
          bg-slate-900 text-white font-semibold
          shadow-md hover:bg-secondary hover:shadow-lg
          transition duration-200 ease-in-out">
                    View all products
                </a>
                <!-- <button id="loadMoreBtn">Load More</button> -->
            </div>
        </div>
    </section>
     <section class="max-w-7xl mx-auto px-6 py-16">
      <div class="grid md:grid-cols-2 gap-12 items-start">
    
        <!-- Left Image -->
        <div class="rounded-2xl overflow-hidden shadow-lg">
          <img src="./assets/images/dinner-set-main.jpg"
               class="w-full h-full object-cover">
          <p class="mt-4 text-gray-700 text-lg">
            Watch the video and learn more about Vaultfurniture
          </p>
        </div>
    
        <!-- Right Content -->
        <div>
          <h2 class="text-4xl font-bold mb-4">Why Choose Us</h2>
          <p class="text-gray-500 mb-8">
            Here are the reasons why Vaultfurniture stands out as the ultimate choice in lighting solutions
          </p>
    
          <!-- Accordion -->
          <div class="space-y-4">
    
            <!-- Item -->
            <div class="accordion-item border-b pb-4">
              <div class="flex justify-between items-center cursor-pointer accordion-header">
                <h3 class="text-lg font-semibold">Sustainability</h3>
                <span class="text-2xl font-light toggle-icon">+</span>
              </div>
              <div class="accordion-content hidden mt-3 text-gray-600">
                We prioritize eco-friendly materials and sustainable production methods to reduce environmental impact.
              </div>
            </div>
    
            <!-- Item -->
            <div class="accordion-item border-b pb-4">
              <div class="flex justify-between items-center cursor-pointer accordion-header">
                <h3 class="text-lg font-semibold">Unrivaled Quality</h3>
                <span class="text-2xl font-light toggle-icon">+</span>
              </div>
              <div class="accordion-content hidden mt-3 text-gray-600">
                Every product undergoes strict quality testing to ensure durability and long-lasting performance.
              </div>
            </div>
    
            <!-- Item -->
            <div class="accordion-item border-b pb-4">
              <div class="flex justify-between items-center cursor-pointer accordion-header">
                <h3 class="text-lg font-semibold">Unmatched Variety</h3>
                <span class="text-2xl font-light toggle-icon">+</span>
              </div>
              <div class="accordion-content hidden mt-3 text-gray-600">
                Explore a wide selection of modern, classic, and custom lighting designs tailored to every space.
              </div>
            </div>
    
            <!-- Item -->
            <div class="accordion-item border-b pb-4">
              <div class="flex justify-between items-center cursor-pointer accordion-header">
                <h3 class="text-lg font-semibold">Legacy of Excellence</h3>
                <span class="text-2xl font-light toggle-icon">+</span>
              </div>
              <div class="accordion-content hidden mt-3 text-gray-600">
                With years of experience in the industry, we've built a reputation based on trust and innovation.
              </div>
            </div>
    
          </div>
        </div>
      </div>
    </section>
    <section class="bg-gray-200 py-20">
  <div class="max-w-3xl mx-auto text-center px-6">

    <!-- Heading -->
    <h2 class="text-3xl md:text-4xl font-medium text-dark-text leading-snug">
      Subscribe to our newsletter and
      <br class="hidden md:block" />
      grab <span class="font-extrabold">30% OFF</span>
    </h2>

    <!-- Form -->
    <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">

      <!-- Icon + Input Wrapper -->
      <div class="relative w-full sm:w-auto flex items-center">

        <!-- Mail Icon -->
        <div class="absolute left-4 text-gray-400">
            <i class="fa-regular fa-envelope"></i>
        </div>

        <!-- Input -->
        <input 
          type="email" 
          placeholder="Your Email..."
          class="w-full sm:w-96 pl-12 pr-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 transition"
        >
      </div>

      <!-- Button -->
      <button class="px-8 py-3 rounded-full bg-dark-text text-white font-medium hover:bg-gray-900 transition duration-300 shadow-md">
        Subscribe
      </button>

    </div>

  </div>
</section>
</main>
<?php
    require_once("./layout/footer.php");
?>
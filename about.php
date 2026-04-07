<?php
define('BASE_URL', '');
require_once("./layout/header.php");
?>

<main class="relative">
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
</main>
<?php
    require_once("./layout/footer.php");
?>
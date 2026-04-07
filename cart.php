<?php
define('BASE_URL', '');
require_once("./layout/header.php");
?>
<main class="relative">

  <section class="bg-dark-text py-10 md:py-20 px-4">
    <div class="container mx-auto space-y-6">
      <div class="text-center space-y-3">
        <h3 class="text-2xl md:text-4xl text-primary font-bold">Browse your Cart Contents</h3>
        <p class="text-slate-500 text-base max-w-lg mx-auto">Study has shown that you get more values when you take
          prompt actionable moves on your cart contents</p>
      </div>
    </div>
  </section>
  <section class="bg-slate-100/20 py-10 px-4">
    <div class="container mx-auto grid md:grid-cols-3 gap-4 py-10">
      <aside class="md:col-span-2 divide-y divide-slate-100">
        <div class="flex justify-between items-center bg-pink-500 text-primary py-3 px-4 md:px-6 rounded-t-md">
          <h3 class="text-lg md:text-xl font-semibold">Shopping Cart</h3>
          <p class="text-xs font-medium"><span class="cartTotal"></span> items</p>
        </div>
        <div class="cartContainer divide-y divide-slate-200">

        </div>
      </aside>
      <aside class="flex flex-col gap-4 w-full bg-primary p-4 rounded-md shadow-xl">
        <h2 class="text-xl font-bold">Order Summary</h2>
        <div class="flex flex-col border-solid divide-y divide-slate-200 text-secondary py-2 shrink-0">
          <div class="flex justify-between items-center gap-2 py-1 px-2 text-sm md:text-base">
            <p class="">Subtotal:</p>
            <p class="cartGrandTotal font-semibold">₦0</p>
          </div>
          <div class="flex justify-between items-center gap-2 py-1 px-2 text-sm md:text-base">
            <p class="">Discount Applied:</p>
            <p class="cartDiscountTotal font-semibold text-green-600">(0)</p>
          </div>
          <div class="flex justify-between items-center gap-2 py-1 px-2 text-sm md:text-base">
            <p class="">Electricity VAT:</p>
            <p class="font-semibold">0</p>
          </div>
          <div class="flex justify-between items-center gap-2 py-1 px-2 text-sm md:text-base">
            <p class="">Grand Total:</p>
            <p class="cartFinalTotal text-base md:text-lg font-bold">₦0</p>
          </div>
          <a href="./checkout"
            class="bg-dark-text hover:brightness-102 text-primary text-base md:text-lg rounded-md flex justify-center items-center gap-2 mt-2 p-2 "><i class="fa-solid fa-wallet"></i> Proceed to Checkout</a>
          <p class="opacity-60 text-xs text-center pt-1">100% Secure with MasterCard, Paystack and Flutter Technology
          </p>
        </div>
      </aside>
    </div>
  </section>
</main>
<?php
    require_once("./layout/footer.php");
?>
<?php
define('BASE_URL', '');
require_once("./layout/header.php");
if(!isset($_SESSION['id'])) header("location: ./signin?page=checkout")
?>
<main class="relative">
  <section class="bg-dark-text py-10 md:py-20 px-4">
    <div class="container mx-auto space-y-6">
      <div class="text-center space-y-3">
        <h3 class="text-2xl md:text-4xl text-primary font-bold">Checkout your Cart Contents</h3>
        <p class="text-slate-500 text-base max-w-lg mx-auto">Study has shown that you get more values when you take prompt actionable moves on your cart contents</p>
      </div>
    </div>
  </section>
  <section class="bg-white py-10 px-4">
    <form id="checkoutForm" class="container mx-auto grid md:grid-cols-3 gap-4 py-10">
      <aside class="md:col-span-2 divide-y divide-slate-100">
        <div class="flex justify-between items-center bg-pink-500 text-primary text-green-100 py-3 px-4 md:px-6 rounded-t-md">
          <h3 class="text-lg md:text-xl font-semibold">Items to Checkout</h3>
          <p class="text-xs font-medium"><span class="cartTotal"></span> items</p>
        </div>
        <div class="checkoutContainer divide-y divide-slate-200">

        </div>
        <div class="bg-dark-text hover:brightness-102 text-primary text-base md:text-lg rounded-md flex justify-between items-center gap-2 mt-2 p-2">
            <p class="text-white">Grand Total:</p>
            <p class="cartFinalTotal text-base md:text-lg font-bold">₦0</p>
        </div>
      </aside>
      <aside class="w-full flex flex-col bg-white p-4 rounded-md shadow-xl">
        <!-- <div class="relative flex-1 hidden md:flex flex-col justify-center items-center bg-secondary rounded-md text-white/60 p-6">
          <p class="tracking-tight text-4xl"><?= isset($_SESSION['name']) ? $_SESSION['name'] : "Vault Furniture" ?></p>
        </div> -->
        <!-- <div class="flex flex-col border-solid divide-y divide-slate-200 text-dark-text py-2 shrink-0">
          </div> -->
          <input type="hidden" name="" value="<?=  $_SESSION['email'] ?>" id="email">
            <h3 class="">Enter Delivery Address:</h3>
            <textarea name="location" id="location" rows="5" required class="p-4 rounded-md border border-slate-300 resize-none bg-white text-slate-500"></textarea>
          <button type="submit" class="bg-dark-text hover:brightness-100 text-white text-base md:text-lg rounded-md flex justify-center items-center gap-2 mt-2 p-2 ">Place Order</button>
          <p class="opacity-60 text-xs text-center pt-1">Feel free to place your order any time of the day</p>
      </aside>
    </form>
  </section>
</main>
<?php
    require_once("./layout/footer.php");
?>
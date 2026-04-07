<?php 
define('BASE_URL', '');
    require_once("./layout/header.php");
?>
    <div class="bg-white py-6 px-4">
        <div class="container mx-auto flex flex-col md:flex-row gap-6">
            <div class="flex-1 flex justify-center items-center">
                <form id="signinForm" method="POST" class="w-full max-w-md flex flex-col gap-3 py-10">
                    <h3 class="font-semibold text-lg md:text-2xl text-dark-text text-center">Sign In</h3>
                    <p class="text-slate-500 text-center text-sm md:text-base mb-6">Welcome, enter your details to gain access</p>

                    <input type="email" name="email" id="email" required placeholder="Email" class="p-2 rounded-md border border-slate-200 text-slate-500">
                    <input type="password" name="password" id="password" required placeholder="Password" class="p-2 rounded-md border border-slate-200 text-slate-500">
                    <button type="submit" name="trigger_signin" class="py-2 px-4 bg-dark-text rounded-md text-primary cursor-pointer">Log in</button>
                    <a href="./signup" class="text-center p-2 -mt-2 text-slate-700">Don't have an account yet? Signup</a>
                </form>
            </div>
            <div class="flex-1 relative hidden md:flex justify-center items-center rounded-md bg-secondary overflow-hidden">
                <img src="./assets/images/sofa-chair-black.jpg" alt="" class="absolute top-0 left-0 w-full h-full opacity-70">
            </div>
        </div>

    </div>
    <?php
    require_once("./layout/footer.php");
    ?>

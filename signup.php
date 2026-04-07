<?php 
define('BASE_URL', '');
    require_once("./layout/header.php");
?>
    <div class="bg-white py-6 px-4">
        <div class="container mx-auto flex flex-col md:flex-row gap-6">
            <div class="flex-1 flex justify-center items-center">
                <form id="signupForm" method="POST" class="w-full max-w-md flex flex-col gap-3 py-10">
                    <input type="hidden" name="role" value="user" id="role" >
                    <h1 class="font-semibold text-lg md:text-2xl text-dark-text text-center">Create Account</h1>
                    <p class="text-slate-500 text-center text-sm md:text-base mb-6">Enter your details in the form below</p>
                    <input type="text" name="firstname" required placeholder="First Name" class="p-2 rounded-md border border-slate-200 text-slate-500">
                    <input type="text" name="lastname"  required placeholder="Last Name" class="p-2 rounded-md border border-slate-200 text-slate-500">
                    <input type="email" name="email"  required placeholder="Email" class="p-2 rounded-md border border-slate-200 text-slate-500">
                    <input type="password" name="password"  required placeholder="Password" class="p-2 rounded-md border border-slate-200 text-slate-500">
                    <input type="password" name="confirm_password"  required placeholder="Confirm Password" class="p-2 rounded-md border border-slate-200 text-slate-500">
                    <button type="submit" name="trigger_signup" class="py-2 px-4 bg-tertiary rounded-md text-white cursor-pointer">Sign up</button>
                    <a href="./signin" class="text-center p-2 -mt-2 text-slate-700">Already a member? Login</a>
                </form>
            </div>
            <div class="flex-1 relative hidden md:flex justify-center items-center rounded-md bg-green-700 overflow-hidden">
                <img src="./assets/images/sofa-living-room-orange.jpg" alt="" class="absolute top-0 left-0 w-full h-full opacity-70">
            </div>
        </div>

    </div>
<?php
    require_once("./layout/footer.php");
    ?>
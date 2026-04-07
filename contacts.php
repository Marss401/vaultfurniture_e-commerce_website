<?php 

define('BASE_URL', '');
    require_once("./layout/header.php");

?>
<main class="min-h-screen relative bg-white">
        <div class="container mx-auto flex flex-col md:flex-row gap-6">
            <aside class="relative flex-1 hidden md:block py-20 min-h-[360px]">
                <img src="./assets/images/sofa-living-room-main.jpg" alt="ssofa-living-main" class="absolute top-0 left-0 w-full h-full object-cover">
            </aside>
            <aside class="flex-1 h-full grid place-items-center p-4 md:p-10">
                <form id="contactForm" class="w-full md:max-w-md mx-auto p-4 flex flex-col gap-3">
                    <div class="py-2 text-center">
                        <h3 class="text-lg md:text-2xl font-semibold text-dark-text my-2 leading-4">We are always <span class="text-pink-500">Listening...</span></h3>
                        <p class="text-sm md:text-base text-slate-500 mb-4">Speak to us directly through the form below</p>
                    </div>
                    <div class="relative">
                        <label for="fullname" class="p-1.5 text-sm text-slate-700 font-light">Full Name</label>
                        <input required placeholder="Abby Salako" type="text" name="fullname" id="fullname" class="flex w-full p-2 border border-slate-300 rounded-md outline-none hover:border-slate-500">
                    </div>
                    <div class="relative">
                        <label for="email" class="p-1.5 text-sm text-slate-700 font-light">Email Address</label>
                        <input required placeholder="abbysalako@egmail.com" type="email" name="email" id="email" class="flex w-full p-2 border border-slate-300 rounded-md outline-none hover:border-slate-500">
                    </div>
                    <div class="relative">
                        <label for="phone" class="p-1.5 text-sm text-slate-700 font-light">Phone Number</label>
                        <div class="flex w-full border border-slate-300 rounded-md  hover:border-slate-500 overflow-hidden">
                            <div class="bg-tertiary text-white grid place-items-center px-2 text-base flex-shrink-0 w-max">+234</div>
                            <input required maxlength="10" minlength="10" placeholder="8032839471" type="text" name="phone" id="phone" class="flex-1 w-full p-2 outline-none">
                        </div>
                    </div>
                    <div class="relative">
                        <label for="password" class="p-1.5 text-sm text-slate-700 font-light">Message</label>
                        <textarea required placeholder="Send message..." rows="5" name="message" id="message" class="flex w-full p-2 border border-slate-300 rounded-md outline-none hover:border-slate-500"></textarea>
                    </div>
                    <button type="submit" class="flex gap-2 items-center disabled:cursor-not-allowed disabled:bg-slate-300 py-2 px-6 md:px-10 rounded-md bg-dark-text text-white cursor-pointer w-max">Send</button>
                </form>
            </aside>
        </div>
    </main>

<?php
    require_once("./layout/footer.php");
    ?>
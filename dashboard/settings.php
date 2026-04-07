<?php
$folder = $_SERVER['DOCUMENT_ROOT'] . "/vaultfurniture";
require_once("$folder/layout/dash_header.php");
$id = $_SESSION["id"];
$fullname = $_SESSION["name"];
$email = $_SESSION["email"];
?>
<!-- // content goes header_register_callback -->

<div class="bg-white p-6 mx-3 mb-6 rounded-xl border border-gray-200 shadow-sm">

    <div class="flex items-center gap-4">

        <!-- Avatar -->
        <div class="h-12 w-12 rounded-full bg-indigo-100 text-indigo-600 grid place-items-center text-xl">
            <i class="fa-solid fa-user"></i>
        </div>

        <!-- Welcome Text -->
        <div>
            <h2 class="text-xl md:text-2xl font-semibold text-gray-800">
                Hi, <?= $fullname ?>
            </h2>
            <p class="text-sm text-gray-500">
                Welcome back! Manage your profile and dashboard activities here.
            </p>
        </div>

    </div>

</div>
<section class="bg-white my-4 mx-3 p-4 rounded-sm mb-4 shadow-[#0001]">
    <form action="" id="profileForm" class="grid md:grid-cols-2 gap-2 md:gap-8">
        <input type="hidden" name="trigger_edit">
        <aside class="space-y-2 ">
            <p class="text-sm text-green-600 font-bold py-4 leading-2 ">Personal Information</p>
            <label for="fullname" class="relative">
                <p class="text-sm text-slate-400 font-bold leading-6">Full Name</p>
                <input required value="<?= $fullname ?>" id="fullname" name="fullname" type="text" class="placeholder:text-sm w-full border border-slate-300 hover:border-primary rounded-md p-2 bg-transparent text-slate-600">
            </label>
            <label for="email" class="relative py-1 block">
                <p class="text-sm text-slate-400 font-bold leading-6">Email</p>
                <input required value="<?= $email ?>" id="email" name="email" type="text" class="placeholder:text-sm w-full border border-slate-300 hover:border-primary rounded-md p-2 bg-transparent text-slate-600">
            </label>
            <p class="text-sm text-green-600 font-bold py-4 leading-2 ">Security Information</p>
            <label for="password" class="relative py-1 block ">
                <p class="text-sm text-slate-400 font-bold leading-6">New Password <span class="text-xs opacity-90">(Leave empty if you wish to keep your old password)</span></p>
                <input id="password" name="password" type="password" placeholder="********" class="placeholder:text-sm w-full border border-slate-300 hover:border-primary rounded-md p-2 bg-transparent text-slate-600">
            </label>
            <label for="conf_password" class="relative py-1 block">
                <p class="text-sm text-slate-400 font-bold leading-6">Confirm New Password</p>
                <input id="conf_password" name="conf_password" type="password" placeholder="Re-enter password if using a new password" class="placeholder:text-sm w-full border border-slate-300 hover:border-primary rounded-md p-2 bg-transparent text-slate-600">
            </label>
            <label for="current_password" class="relative py-1 block">
                <p class="text-sm text-slate-400 font-bold leading-6">Current Password <span class="text-xs opacity-90">(Verify it is you making the changes)</span></p>
                <input required id="current_password" name="current_password" type="password" placeholder="Enter your current password here" class="placeholder:text-sm w-full border border-slate-300 hover:border-primary rounded-md p-2 bg-transparent text-slate-600">
            </label>
            <button type="submit" class="py-2 px-4 w-max text-white bg-dark-text cursor-pointer rounded-md"> Save Profile</button>
    </form>
</section>


<?php
require_once("$folder/layout/dash_footer.php");
?>
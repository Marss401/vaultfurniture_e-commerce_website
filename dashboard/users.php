<?php
ob_start();
$folder = $_SERVER['DOCUMENT_ROOT'] . "/vaultfurniture";
require_once("$folder/layout/dash_header.php");
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./overview");
    exit();
}
ob_end_flush();
?>
<!-- Content Goes Here -->
<div class="bg-white p-6 mx-3 rounded-xl mb-6 border border-gray-200 shadow-sm">

    <!-- Section Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Users Overview</h2>
            <p class="text-sm text-gray-500">View and manage all registered users</p>
        </div>

        <!-- <button
            type="button"
            id="createUser"
            class="flex items-center gap-2 px-4 py-2 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            <i class="fa-solid fa-plus"></i>
            Add User
        </button> -->
    </div>

    <!-- Table Container -->
    <div class="overflow-x-auto rounded-lg border border-gray-200">

        <table class="min-w-full text-sm">

            <!-- Table Header -->
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">S/N</th>
                    <th class="px-4 py-3 text-left">User Details</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Role</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="divide-y divide-gray-100 text-gray-700">
                    <?php
                    $table = "users";
                    $find_query = $db->query("SELECT id, name, email, role FROM users WHERE role = 'user' ORDER BY createdAt DESC");
                    if ($find_query->num_rows > 0) {
                        $sn = 0;
                        while ($row = $find_query->fetch_assoc()) {
                            $sn++;
                            $id = $row['id'];
                            $fullname = $row['name'];
                            $email = $row['email'];
                            $role = $row['role'];
                            $data = json_encode($row);
                            // Use a HEREDOC to show user details
                            echo <<<_HTML
                    <tr class="hover:bg-slate-100">
                        <td class="text-center">$sn</td>
                        <td>
                            <p class="text-sm md:text-base text-slate-700 whitespace-nowrap font-semibold">$fullname</p>
                        </td>
                        <td class="text-center">$email</td>
                        <td class="text-center">$role</td>
                        <td class="text-center">
                            <div class="flex justify-center gap-2 w-full">
                                <button title="Edit" data-users='$data' class="editUserBtn cursor-pointer py-1 px-3 bg-bluish text-primary text-sm rounded-md hover:bg-grey"><i class="fa-solid fa-file-pen"></i></button>
                                <button title="Delete" data-id='$id' data-page="user.php" class="deleteBtn cursor-pointer py-1 px-3 bg-pink-500 text-white text-sm rounded-md hover:bg-pink-600"><i class="fa-solid fa-trash-can"></i></button>
                            </div>
                        </td>
                    </tr>
_HTML;
                        }
                    } else {
                        echo '<tr><td colspan="5" class="text-center py-4">No User found</td></tr>';
                        exit;
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
    <dialog id="userModal">
        <section
            class="fixed top-0 left-0 w-full h-screen overflow-y-scroll grid place-items-center bg-slate-600/50 p-6 backdrop-blur-sm">
            <div id="closeModal" class="absolute top-0 left-0 w-full h-screen overflow-y-scroll grid place-items-center bg-slate-600/50 p-6 backdrop-blur-sm">
                <button class="absolute top-4 right-4 text-primary text-sm font-semibold bg-[#f66] h-6 w-6 flex justify-center items-center rounded-full">&times;</button>
            </div>
            <form id="userForm" class="relative z-10 space-y-1.5 w-full max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg">
                <h3 id="formTitle" class="text-xl font-semibold text-yellowish pb-2 mb-4 border-b border-slate-300">Add User</h3>
                <input type="hidden" name="trigger_edit" id="trigger_edit">
                <div class="relative">
                    <label for="fullname" class="text-xs font-semibold text-slate-400">Full Name</label>
                    <input required type="text" name="fullname" id="fullname" placeholder="Hannah Banana" class="py-2 px-4 rounded-md border border-slate-300 w-full text-slate-600 text-sm">
                </div>
                <div class="relative">
                    <label for="email" class="text-xs font-semibold text-slate-400">Email Address</label>
                    <input required type="email" name="email" id="email" placeholder="Hannahbanana@gmail.com" class="py-2 px-4 rounded-md border border-slate-300 w-full text-slate-600 text-sm">
                </div>
                <div class="relative pb-2">
                    <label for="role" class="text-xs font-semibold text-slate-400">Role</label>
                    <select name="role" id="role" class="py-2 px-4 rounded-md border border-slate-300 w-full text-slate-600 text-sm bg-transparent">
                        <option class="bg-transparent font-sans" value="admin">admin</option>
                        <option class="bg-transparent font-sans" value="user">user</option>
                    </select>
                </div>
                <button type="submit" class="py-1 px-4 bg-slate-900 rounded-md text-white cursor-pointer flex items-center gap-2" id="saveBtn"><i class="fa-solid fa-download"></i> <span class="-mt-1">Save Record</span></button>
            </form>
        </section>
    </dialog>

    <?php
    require_once("$folder/layout/dash_footer.php");
    ?>
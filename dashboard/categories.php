<?php
ob_start();
$folder = $_SERVER['DOCUMENT_ROOT'] . "/vaultfurniture";
require_once("$folder/layout/dash_header.php");
// if ($_SESSION['role'] === "user") header("location: ./overview");
ob_end_flush();
?>
<!-- Content Goes Here -->
<div class="bg-white p-6 mx-3 mb-6 rounded-xl border border-gray-200 shadow-sm">

    <!-- Header -->
    <div class="flex justify-between items-center gap-4 mb-4">

        <div>
            <h2 class="text-xl md:text-2xl font-semibold text-gray-800">
                Category Overview
            </h2>
            <p class="text-sm text-gray-500">
                Manage product categories and organization.
            </p>
        </div>

        <!-- Add Category Button -->
        <button
            type="button"
            id="createCategory"
            class="flex items-center gap-2 px-4 py-2 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">

            <i class="fa-solid fa-plus"></i>
            New Category
        </button>

    </div>

    <!-- Table -->
    <div class="overflow-x-auto rounded-lg border border-gray-200">

        <table class="min-w-full text-sm">

            <!-- Table Header -->
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">S/N</th>
                    <th class="px-4 py-3 text-left">Category Details</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="divide-y divide-gray-100 text-gray-700">
                <?php
                $table = "categories";
                $find_query = $db->query("SELECT id, name FROM $table ORDER BY createdAt ASC");

                if ($find_query && $find_query->num_rows > 0) {
                    $sn = 0;
                    while ($row = $find_query->fetch_assoc()) {
                        $sn++;
                        $id = $row['id'];
                        $name = $row['name'];
                        $data = json_encode($row);
                        echo <<<_HTML
            <tr class="hover:bg-slate-100">
                <td class="text-center">$sn</td>
                <td>
                    <p class="text-sm md:text-base text-slate-700 whitespace-nowrap font-semibold">$name</p>
                </td>
                <td class="text-center">
                    <div class="flex justify-center gap-2 w-full">
                        <button title="Edit" data-categories='$data' class="editCategoryBtn cursor-pointer py-1 px-3 bg-bluish text-primary text-sm rounded-md hover:bg-grey"><i class="fa-solid fa-file-pen"></i></button>
                        <button title="Delete" data-id='$id' data-page="category.php" class="deleteBtn trigger_delete cursor-pointer py-1 px-3 bg-pink-500 text-white text-sm rounded-md hover:bg-pink-600"><i class="fa-solid fa-trash-can"></i></button>
                    </div>
                </td>
            </tr>
_HTML;
                    }
                } else {
                    echo '<tr><td colspan="7" class="text-center py-4">No Category found</td></tr>';
                }
                ?>
            </tbody>

        </table>
    </div>
</div>

<dialog id="categoryModal">
    <section style="inset-inline-start: 0; scrollbar-width: none;" class="fixed z-50 top-0 bottom-0 left-0 w-full min-h-screen overflow-y-auto grid place-items-center bg-secondary p-6 backdrop-blur-sm">
        <div id="closeModal" class="absolute top-0 left-0 w-full h-full overflow-y-scroll grid place-items-center p-6">
            <button class="absolute top-4 right-4 text-white text-sm font-semibold bg-pink-600 h-6 w-6 flex justify-center items-center rounded-full">&times;</button>
        </div>
        <form id="categoryForm" method="POST" class="relative z-10 space-y-1.5 w-full max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg">
            <h3 id="formTitle" class="text-xl font-semibold text-green-600 pb-2 mb-4 border-b border-slate-300">Create Category</h3>
            <input type="hidden" name="id" id="categoryId">
            <input type="hidden" name="action" id="categoryAction" value="create">
            <input type="hidden" name="trigger_category_create" value="1">
            <div class="relative"> 
                <label for="name" class="text-xs font-semibold text-slate-400">Category Name</label> 
                <input required type="text" name="name" id="name" placeholder="Name e.g. Table" class="py-2 px-4 rounded-md border border-slate-300 w-full text-slate-600 text-sm"> 
            </div>
            <button type="submit" class="py-1 px-4 bg-slate-900 rounded-md text-primary cursor-pointer flex items-center gap-2" id="saveBtn"><i class="fa-solid fa-download"></i>
                <span class="-mt-1">Save Record</span>
            </button>
        </form>
    </section>
</dialog>
<?php
require_once("$folder/layout/dash_footer.php");
?>
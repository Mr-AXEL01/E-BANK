<?php
require_once "../services/AccountService.php";

$accountService = new AccountService();

// Handle account deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteaccount']) && isset($_POST['delete'])) {
    $accountId = $_POST['delete'];

    // Assuming you have a deleteAccount method in your AccountService
    $accountService->deleteAccount($accountId);

    // Redirect or display a success message as needed
    header('Location: accounts.php');
    exit();
}

// Fetch accounts
$accounts = $accountService->getAccounts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
    <title>Bank Management System - Accounts</title>
    <!-- Add any additional stylesheets or scripts as needed -->
</head>

<body class="bg-gray-100 bg-cover">
<header class="header sticky h-[12vh]  top-0 bg-white shadow-md flex items-center justify-between px-8 py-02 z-50 	">
        <a href="" class="flex items-center font-bold text-blue-950	gap-[7px]">
            <img src="images/CentralLogo.png" alt="" class="md:h-[60px] md:w-[150px] h-[35px] w-[90px]">
            ADMIN
        </a>
        <nav class="nav font-semibold w-[100%] text-lg">
            <ul class="flex items-center w-[100%] justify-center  ">

                <li class="p-4 border-b-2 border-blue-500 border-opacity-0 hover:border-opacity-100 hover:text-blue-500 duration-200 cursor-pointer">
                    <select name="clients" id="selectOption" class="outline-none rounded">
                        <option class="font-semibold text-lg" value="Banks">Locations</option>

                        <option class="font-semibold text-lg" value="Banks">Banks</option>
                        <option class="font-semibold text-lg" value="agency">agency</option>
                        <option class="font-semibold text-lg" value="ATM">ATM</option>
                    </select>
                </li>

                <li class="p-4 border-b-2 border-blue-500 border-opacity-0 hover:border-opacity-100 hover:text-blue-500 duration-200 cursor-pointer">
                    <select name="clients" id="selectOptions1" class="outline-none rounded">
                        <option class="font-semibold text-lg" value="client">Operations</option>

                        <option class="font-semibold text-lg" value="client">Users</option>
                        <option class="font-semibold text-lg" value="accounts">accounts</option>
                        <option class="font-semibold text-lg" value="transactions">transactions</option>
                    </select>
                </li>
                <li class="p-4 border-b-2 border-red-500 border-opacity-0 hover:border-opacity-100 hover:text-red-500 duration-200 cursor-pointer">
                    <a href="index.php" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">Log Out</a>
                </li>
            </ul>
        </nav>

    </header>

    <script src="navbar.js">

    </script>
    <div class="flex justify-evenly items-center h-[20vh]">
        <h1 class="text-[50px] text-black">ACCOUNTS</h1>
        <a href="addAccount.php" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 border border-blue-600 rounded">ADD ACCOUNT</a>
    </div>

    <section class="min-h-[75vh]">
        <!-- Display accounts in a table -->
        <table id="dataTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="w-[11%] px-6 py-3 text-center" scope="col">Account ID</th>
                    <th class="w-[11%] px-6 py-3 text-center" scope="col">Balance</th>
                    <th class="w-[11%] px-6 py-3 text-center" scope="col">RIB</th>
                    <th class="w-[11%] px-6 py-3 text-center" scope="col">User ID</th>
                    <!-- Add more columns as needed -->
                    <th class="w-[11%] px-6 py-3 text-center" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accounts as $account) : ?>
                    <tr>
                        <td class="px-6 py-4 font-semibold text-center"><?= $account['accountId'] ?></td>
                        <td class="px-6 py-4 font-semibold text-center"><?= $account['balance'] ?></td>
                        <td class="px-6 py-4 font-semibold text-center"><?= $account['RIB'] ?></td>
                        <td class="px-6 py-4 font-semibold text-center"><?= $account['userId'] ?></td>
                        <!-- Add more columns as needed -->

                        <!-- Add actions column with delete form -->
                        <td class="px-6 py-4 font-semibold text-center">
                            <form action="accounts.php" method="post" class="cursor-pointer focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                <input type="hidden" name="delete" value="<?= $account['accountId'] ?>">
                                <input type="submit" name="deleteaccount" value="Delete" class="cursor-pointer">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- Include your footer -->
    <?php include 'footer.php'; ?>
</body>

</html>

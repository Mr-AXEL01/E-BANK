<?php
require_once "../services/AccountService.php";
require_once "../services/UserServices.php";
require_once"../models/account/CurrentAccount.php";
require_once"../models/account/SavingsAccount.php";

$accountService = new AccountService();
$userService = new Userservice();

// Fetch user data or other necessary data for form population
$users = $userService->getUser();  // Adjust this based on your UserService implementation

// Logic for editing account
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['edit'])) {
    $accountId = $_GET['edit'];
    $account = $accountService->getAccountById($accountId);

    if ($account) {
        $editMode = true;
        $accountType = $account instanceof CurrentAccount ? 'current' : 'savings';
        $balance = $account->getBalance();
        $RIB = $account->getRIB();
        $userId = $account->getUserId();

        if ($account instanceof CurrentAccount) {
            $overdraftLimit = $account->getOverdraftLimit();
        } elseif ($account instanceof SavingsAccount) {
            $interestRate = $account->getInterestRate();
        }
    }
}

// Logic for adding or editing account
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        $accountType = $_POST['accountType'];
        $balance = $_POST['balance'];
        $RIB = $_POST['RIB'];
        $userId = $_POST['userId'];

        if ($accountType === 'current') {
            $overdraftLimit = $_POST['overdraftLimit'];
            $account = new CurrentAccount(null, $balance, $RIB, $userId, $overdraftLimit);
        } else {
            $interestRate = $_POST['interestRate'];
            $account = new SavingsAccount(null, $balance, $RIB, $userId, $interestRate);
        }

        if (isset($_POST['edited'])) {
            $accountId = $_POST['accountId'];
            $account->setAccountId($accountId);
            $accountService->editAccount($account);
        } else {
            $accountService->addAccount($account);
        }

        // Redirect or display success message as needed
        header('Location: accounts.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($editMode) ? 'Edit' : 'Add' ?> Account</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="max-w-xl mx-auto bg-white p-8 mt-10 shadow-md">
        <h1 class="text-2xl font-bold mb-6"><?= isset($editMode) ? 'Edit' : 'Add' ?> Account</h1>

        <form method="post" action="" class="space-y-4">
            <input type="hidden" name="accountId" value="<?= isset($accountId) ? $accountId : '' ?>">

            <div class="flex space-x-4">
                <div class="flex-1">
                    <label for="accountType" class="block text-sm font-medium text-gray-700">Account Type:</label>
                    <select name="accountType" id="accountType"
                        class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0">
                        <option value="current"
                            <?= isset($accountType) && $accountType === 'current' ? 'selected' : '' ?>>Current
                            Account</option>
                        <option value="savings"
                            <?= isset($accountType) && $accountType === 'savings' ? 'selected' : '' ?>>Savings
                            Account</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="balance" class="block text-sm font-medium text-gray-700">Balance:</label>
                <input type="number" name="balance" value="<?= isset($balance) ? $balance : '' ?>"
                    class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                    required>
            </div>

            <div>
                <label for="RIB" class="block text-sm font-medium text-gray-700">RIB:</label>
                <input type="text" name="RIB" value="<?= isset($RIB) ? $RIB : '' ?>"
                    class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                    required>
            </div>

            <div>
                <label for="userId" class="block text-sm font-medium text-gray-700">User:</label>
                <select name="userId"
                    class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                    required>
                    <?php foreach ($users as $user) : ?>
                    <option value="<?= $user['userId'] ?>"
                        <?= isset($userId) && $userId == $user['userId'] ? 'selected' : '' ?>>
                        <?= $user['username'] ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if (isset($accountType) && $accountType === 'current') : ?>
            <div>
                <label for="overdraftLimit" class="block text-sm font-medium text-gray-700">Overdraft Limit:</label>
                <input type="number" name="overdraftLimit" value="<?= isset($overdraftLimit) ? $overdraftLimit : '' ?>"
                    class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                    required>
            </div>
            <?php else : ?>
            <div>
                <label for="interestRate" class="block text-sm font-medium text-gray-700">Interest Rate:</label>
                <input type="number" name="interestRate" value="<?= isset($interestRate) ? $interestRate : '' ?>"
                    class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                    required>
            </div>
            <?php endif; ?>

            <?php
            if (isset($editMode)) {
                echo '<input type="submit" name="edited"
                    class="mt-4 bg-blue-500 text-white p-2 rounded-md cursor-pointer" value="Edit">';
            } else {
                echo '<input type="submit" name="submit"
                    class="mt-4 bg-green-500 text-white p-2 rounded-md cursor-pointer" value="Add Account">';
            }
            ?>
        </form>
    </div>

    <!-- Add any additional content or scripts as needed -->

</body>

</html>


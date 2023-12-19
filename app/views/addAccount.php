<?php
require_once "../services/AccountService.php";
require_once "../services/UserServices.php";
require_once "../models/account/CurrentAccount.php";
require_once "../models/account/SavingsAccount.php";

$accountService = new AccountService();
$userService = new Userservice();

// Fetch user data or other necessary data for form population
$users = $userService->getUser();  // Adjust this based on your UserService implementation

// Logic for editing account
$editMode = false;
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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $accountType = $_POST['accountType'];
    $balance = $_POST['balance'];
    $RIB = $_POST['RIB'];
    $userId = $_POST['userId'];

    if ($accountType === 'current') {
        $overdraftLimit = $currentAccountData['overdraft_limit'] ?? null;
        $account = new CurrentAccount(null, $balance, $RIB, $userId, $overdraftLimit);
    } else {
        $interestRate = $currentAccountData['interest_rate'] ?? null;
        $account = new SavingsAccount(null, $balance, $RIB, $userId, $interestRate);
    }

    if ($editMode) {
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $editMode ? 'Edit' : 'Add' ?> Account</title>
    <!-- Add Tailwind CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white p-6 rounded-md shadow-md">
        <h1 class="text-2xl font-bold mb-6"><?= $editMode ? 'Edit' : 'Add' ?> Account</h1>

        <form method="post" action="" class="space-y-4">
            <input type="hidden" name="accountId" value="<?= isset($accountId) ? $accountId : '' ?>">

            <div class="flex flex-col">
                <label for="accountType" class="text-sm font-semibold mb-1">Account Type:</label>
                <select name="accountType" id="accountType" class="p-2 border rounded">
                    <option value="current" <?= isset($accountType) && $accountType === 'current' ? 'selected' : '' ?>>Current Account</option>
                    <option value="savings" <?= isset($accountType) && $accountType === 'savings' ? 'selected' : '' ?>>Savings Account</option>
                </select>
            </div>

            <div class="flex flex-col">
                <label for="balance" class="text-sm font-semibold mb-1">Balance:</label>
                <input type="number" name="balance" value="<?= isset($balance) ? $balance : '' ?>" class="p-2 border rounded" required>
            </div>

            <div class="flex flex-col">
                <label for="RIB" class="text-sm font-semibold mb-1">RIB:</label>
                <input type="text" name="RIB" value="<?= isset($RIB) ? $RIB : '' ?>" class="p-2 border rounded" required>
            </div>

            <div class="flex flex-col">
                <label for="userId" class="text-sm font-semibold mb-1">User:</label>
                <select name="userId" class="p-2 border rounded" required>
                    <?php foreach ($users as $user) : ?>
                        <option value="<?= $user['userId'] ?>" <?= isset($userId) && $userId == $user['userId'] ? 'selected' : '' ?>>
                            <?= $user['username'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if (isset($accountType) && $accountType === 'current') : ?>
                <div class="flex flex-col">
                    <label for="overdraftLimit" class="text-sm font-semibold mb-1">Overdraft Limit:</label>
                    <input type="number" name="overdraftLimit" value="<?= isset($overdraftLimit) ? $overdraftLimit : '' ?>" class="p-2 border rounded" required>
                </div>
            <?php else : ?>
                <div class="flex flex-col">
                    <label for="interestRate" class="text-sm font-semibold mb-1">Interest Rate:</label>
                    <input type="number" name="interestRate" value="<?= isset($interestRate) ? $interestRate : '' ?>" class="p-2 border rounded" required>
                </div>
            <?php endif; ?>

            <div class="flex justify-end">
                <input type="submit" name="submit" value="<?= $editMode ? 'Edit' : 'Add' ?> Account"
                    class="bg-blue-500 text-white font-semibold px-4 py-2 rounded cursor-pointer">
            </div>
        </form>
    </div>

</body>

</html>


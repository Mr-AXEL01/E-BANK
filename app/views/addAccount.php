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
    <!-- Add any additional stylesheets or scripts as needed -->
</head>

<body>

    <h1><?= isset($editMode) ? 'Edit' : 'Add' ?> Account</h1>

    <form method="post" action="">
        <input type="hidden" name="accountId" value="<?= isset($accountId) ? $accountId : '' ?>">
        
        <label for="accountType">Account Type:</label>
        <select name="accountType" id="accountType">
            <option value="current" <?= isset($accountType) && $accountType === 'current' ? 'selected' : '' ?>>Current Account</option>
            <option value="savings" <?= isset($accountType) && $accountType === 'savings' ? 'selected' : '' ?>>Savings Account</option>
        </select>

        <label for="balance">Balance:</label>
        <input type="number" name="balance" value="<?= isset($balance) ? $balance : '' ?>" required>

        <label for="RIB">RIB:</label>
        <input type="text" name="RIB" value="<?= isset($RIB) ? $RIB : '' ?>" required>

        <label for="userId">User:</label>
        <select name="userId" required>
            <?php foreach ($users as $user) : ?>
                <option value="<?= $user['userId'] ?>" <?= isset($userId) && $userId == $user['userId'] ? 'selected' : '' ?>>
                    <?= $user['username'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <?php if (isset($accountType) && $accountType === 'current') : ?>
            <label for="overdraftLimit">Overdraft Limit:</label>
            <input type="number" name="overdraftLimit" value="<?= isset($overdraftLimit) ? $overdraftLimit : '' ?>" required>
        <?php else : ?>
            <label for="interestRate">Interest Rate:</label>
            <input type="number" name="interestRate" value="<?= isset($interestRate) ? $interestRate : '' ?>" required>
        <?php endif; ?>

        <?php
        if (isset($editMode)) {
            echo '<input type="submit" name="edited" value="Edit">';
        } else {
            echo '<input type="submit" name="submit" value="Add Account">';
        }
        ?>
    </form>

    <!-- Add any additional content or scripts as needed -->

</body>

</html>

<?php
require_once("../repositories/Database.php");
require("AccountServiceInterface.php");

class AccountService extends Database implements AccountServiceInterface
{
    protected $db;

    public function __construct()
    {
        $this->db = $this->connect();
    }

    public function addAccount(Account $account)
{
    // Common account data
    $balance = $account->getBalance();
    $RIB = $account->getRIB();
    $userId = $account->getUserId();
    $accountType = $account->getAccountType(); // Assuming you have a method to get the account type

    // Insert common data into the 'account' table
    $addAccountQuery = "INSERT INTO account (balance, RIB, userId, account_type) VALUES (:balance, :RIB, :userId, :accountType)";
    $stmt = $this->db->prepare($addAccountQuery);
    $stmt->bindParam(":balance", $balance);
    $stmt->bindParam(":RIB", $RIB);
    $stmt->bindParam(":userId", $userId);
    $stmt->bindParam(":accountType", $accountType);

    try {
        $stmt->execute();
        $accountId = $this->db->lastInsertId();

        // Update the account object with the generated accountId
        $account->setAccountId($accountId);

        // Insert specific data into the respective tables based on the account type
        $this->insertSpecificData($account);

        return $accountId;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

private function insertSpecificData(Account $account)
{
    $accountId = $account->getAccountId();
    $accountType = $account->getAccountType();

    // Insert specific data into the respective tables based on the account type
    switch ($accountType) {
        case 'current':
            $overdraftLimit = $account->getOverdraftLimit(); // Assuming you have a method to get the overdraft limit
            $insertQuery = "INSERT INTO currentaccounts (accountId, overdraft_limit) VALUES (:accountId, :overdraftLimit)";
            break;

        case 'savings':
            $interestRate = $account->getInterestRate(); // Assuming you have a method to get the interest rate
            $insertQuery = "INSERT INTO savingsaccount (accountId, interest_rate) VALUES (:accountId, :interestRate)";
            break;

        default:
            return; // Unsupported account type
    }

    $stmt = $this->db->prepare($insertQuery);
    $stmt->bindParam(":accountId", $accountId);

    // Bind the specific data based on the account type
    switch ($accountType) {
        case 'current':
            $stmt->bindParam(":overdraftLimit", $overdraftLimit);
            break;

        case 'savings':
            $stmt->bindParam(":interestRate", $interestRate);
            break;
    }

    try {
        $stmt->execute();
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}


    public function editAccount(Account $account)
    {
        $accountId = $account->getAccountId();
        $balance = $account->getBalance();
        $RIB = $account->getRIB();
        $userId = $account->getUserId();

        $editAccountQuery = "UPDATE account SET balance = :balance, RIB = :RIB, userId = :userId WHERE accountId = :accountId";
        $stmt = $this->db->prepare($editAccountQuery);
        $stmt->bindParam(":accountId", $accountId);
        $stmt->bindParam(":balance", $balance);
        $stmt->bindParam(":RIB", $RIB);
        $stmt->bindParam(":userId", $userId);

        try {
            $stmt->execute();

            // You can return true or any other success indicator if needed
            return true;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function deleteAccount($accountId)
    {
        $deleteAccountQuery = "DELETE FROM account WHERE accountId = :accountId";
        $stmt = $this->db->prepare($deleteAccountQuery);
        $stmt->bindParam(":accountId", $accountId);

        try {
            $stmt->execute();

            // You can return true or any other success indicator if needed
            return true;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getAccounts($searchTerm = '')
    {
        // Assuming you have an 'account' table with columns 'accountId', 'balance', 'RIB', and 'userId'
        $getAccountsQuery = "SELECT * FROM account WHERE accountId LIKE :searchTerm OR RIB LIKE :searchTerm";
        $stmt = $this->db->prepare($getAccountsQuery);
        $stmt->bindValue(":searchTerm", "%$searchTerm%");

        try {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
?>

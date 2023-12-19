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
        $accountType = $account->getAccountType();

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

    public function editAccount(Account $account)
    {
        $accountId = $account->getAccountId();
        $balance = $account->getBalance();
        $RIB = $account->getRIB();
        $userId = $account->getUserId();
        $accountType = $account->getAccountType();

        $editAccountQuery = "UPDATE account SET balance = :balance, RIB = :RIB, userId = :userId WHERE accountId = :accountId";
        $stmt = $this->db->prepare($editAccountQuery);
        $stmt->bindParam(":accountId", $accountId);
        $stmt->bindParam(":balance", $balance);
        $stmt->bindParam(":RIB", $RIB);
        $stmt->bindParam(":userId", $userId);

        try {
            $stmt->execute();
            $this->updateSpecificData($account);

            return true;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function updateSpecificData(Account $account)
    {
        $accountId = $account->getAccountId();
        $accountType = $account->getAccountType();

        switch ($accountType) {
            case 'current':
                $overdraftLimit = $account->getOverdraftLimit();
                $updateQuery = "UPDATE currentaccounts SET overdraft_limit = :overdraftLimit WHERE accountId = :accountId";
                break;

            case 'savings':
                $interestRate = $account->getInterestRate();
                $updateQuery = "UPDATE savingsaccount SET interest_rate = :interestRate WHERE accountId = :accountId";
                break;

            default:
                return;
        }

        $stmt = $this->db->prepare($updateQuery);
        $stmt->bindParam(":accountId", $accountId);

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

    private function insertSpecificData(Account $account)
    {
        $accountId = $account->getAccountId();
        $accountType = $account->getAccountType();

        switch ($accountType) {
            case 'current':
                $overdraftLimit = $account->getOverdraftLimit();
                $insertQuery = "INSERT INTO currentaccounts (accountId, overdraft_limit) VALUES (:accountId, :overdraftLimit)";
                break;

            case 'savings':
                $interestRate = $account->getInterestRate();
                $insertQuery = "INSERT INTO savingsaccount (accountId, interest_rate) VALUES (:accountId, :interestRate)";
                break;

            default:
                return;
        }

        $stmt = $this->db->prepare($insertQuery);
        $stmt->bindParam(":accountId", $accountId);

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

    public function deleteAccount($accountId)
    {
        $deleteAccountQuery = "DELETE FROM account WHERE accountId = :accountId";
        $stmt = $this->db->prepare($deleteAccountQuery);
        $stmt->bindParam(":accountId", $accountId);

        try {
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getAccounts($searchTerm = '')
    {
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


    public function getAccountById($accountId)
{
    $getAccountQuery = "SELECT * FROM account WHERE accountId = :accountId";
    $stmt = $this->db->prepare($getAccountQuery);
    $stmt->bindParam(":accountId", $accountId);

    try {
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null; // Account not found
        }

        // Determine the account type and return the appropriate object
        $accountType = $result['account_type'];
        if ($accountType === 'current') {
            // Assuming you have a CurrentAccount class
            return new CurrentAccount(
                $result['accountId'],
                $result['balance'],
                $result['RIB'],
                $result['userId'],
                $result['overdraft_Limit'] ?? null // Updated array key and added null coalescing operator
            );
        } elseif ($accountType === 'savings') {
            // Assuming you have a SavingsAccount class
            return new SavingsAccount(
                $result['accountId'],
                $result['balance'],
                $result['RIB'],
                $result['userId'],
                $result['interest_rate']
            );
        }

        return null; // Unsupported account type
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

}
?>

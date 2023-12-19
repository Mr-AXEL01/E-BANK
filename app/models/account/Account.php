<?php

class Account {
    protected $accountId;
    protected $balance;
    protected $RIB;
    protected $userId;

    public function __construct($accountId, $balance, $RIB, $userId) {
        $this->accountId = $accountId;
        $this->balance = $balance;
        $this->RIB = $RIB;
        $this->userId = $userId;
    }

    public function setAccountId($accountId) {
        $this->accountId = $accountId;
    }

    public function getAccountId() {
        return $this->accountId;
    }

    public function getBalance() {
        return $this->balance;
    }

    public function getRIB() {
        return $this->RIB;
    }

    public function getUserId() {
        return $this->userId;
    }
}

?>

<?php

class SavingsAccount extends Account {
    protected $interestRate;

    public function __construct($accountId, $balance, $RIB, $userId, $interestRate) {
        parent::__construct($accountId, $balance, $RIB, $userId);
        $this->interestRate = $interestRate;
    }

    public function getInterestRate() {
        return $this->interestRate;
    }

    public function getAccountType()
    {
        return 'savings';
    }

}

?>

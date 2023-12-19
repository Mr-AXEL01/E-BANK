<?php
require_once"Account.php";

class CurrentAccount extends Account {
    protected $overdraftLimit;

    public function __construct($accountId, $balance, $RIB, $userId, $overdraftLimit) {
        parent::__construct($accountId, $balance, $RIB, $userId);
        $this->overdraftLimit = $overdraftLimit;
    }

    public function getOverdraftLimit() {
        return $this->overdraftLimit;
    }

    public function getAccountType()
    {
        return 'current';
    }

}

?>

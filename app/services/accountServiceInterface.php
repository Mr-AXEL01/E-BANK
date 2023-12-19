<?php

interface AccountServiceInterface {
    public function addAccount(Account $account);
    public function getAccounts($searchTerm = '');
    public function editAccount(Account $account);
    public function deleteAccount($accountId);
}

?>

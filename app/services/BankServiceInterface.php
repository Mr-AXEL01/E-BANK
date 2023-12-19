<?php



interface BankInterface{
 
    public function addBank(Bank $bank);

    public function getBanks();
   
    public function showeditdbank($id);

    public function editdBank(Bank $bank, $id);

    public function deleteBanks($id);
}


?>
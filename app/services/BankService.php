<?php
require_once("../repositories/Database.php");
require("BankServiceInterface.php");

class Bankservice extends Database implements BankInterface
{

    protected $db;


    public function addBank(Bank $bank)
    {

        $db = $this->connect();

        // $bankId = $bank->getbankId();
        $bankName = $bank->getbankName();
        $bankLogo = $bank->getlogo();
        $addag = "INSERT INTO bank (logo,bankName) VALUES (  :logo , :bankName)";
        $stmt = $db->prepare($addag);
        $stmt->bindParam(":bankName", $bankName);
        $stmt->bindParam(":logo", $bankLogo);
        try {
            $stmt->execute();
            echo "added";
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        header('location: Banks.php');

    }

    public function getBanks()
    {
        $db = $this->connect();

        $query   = "SELECT * FROM bank";

        $getbank = $db->query($query);
        $result = $getbank->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    public function showeditdbank($id){
        $db = $this->connect();
            $bnkinfo = "SELECT * FROM bank WHERE bankId = $id";
            $getbank = $db->query($bnkinfo);
            $result = $getbank->fetch(PDO::FETCH_ASSOC);
        
            $logo = $result["logo"];
            $name = $result["bankName"];
            $bankId = $result["bankId"];
        
            return [$logo, $name,$bankId];
    
}


public function editdBank(Bank $bank, $id){
    $db = $this->connect();

    $bankName = $bank->getbankName();
    $bankLogo = $bank->getlogo();

    $updateQuery = "UPDATE bank SET logo = :logo, bankName = :bankName WHERE bankId = :id";

    $stmt = $db->prepare($updateQuery);
    $stmt->bindParam(":bankName", $bankName);
    $stmt->bindParam(":logo", $bankLogo);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT); 

    try {
        $stmt->execute();
    } catch (PDOException $e) {
        die($e->getMessage());
    }

    header('location: Banks.php');
}
public function deleteBanks($id){
    $db = $this->connect();

    $deleteAgencies = "DELETE FROM agency WHERE bankId = $id";
    $db->query($deleteAgencies);

    $deleteATM = "DELETE FROM atm WHERE bankid = $id";
    $db->query($deleteATM);

    $deleteBank = "DELETE FROM bank WHERE bankid = $id";
    $db->query($deleteBank);
    header('location: Banks.php');

}

}
?>
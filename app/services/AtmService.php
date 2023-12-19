<?php
require_once("../repositories/Database.php");
require("AtmServiceInterface.php");

class Atmservice extends Database implements AtmInterface
{

    protected $db;


    public function addAtm(Atm $Atm)
    {

        $db = $this->connect();

        // $agencyId = $agency->getagencyId();
        $adress = $Atm->getAtmAdress();
        $bankId = $Atm->getBankId();
       


 
        $addag = "INSERT INTO atm (adress,bankId)  VALUES ( :adress,:bankId)";
        $stmt = $db->prepare($addag);
        // $stmt->bindParam(":agencyId", $agencyId);
        $stmt->bindParam(":adress", $adress);
        
        $stmt->bindParam(":bankId", $bankId);
      

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}

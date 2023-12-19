<?php
require("../repositories/Database.php");



Class Atm{

    private $atmId;
    private $adress;
    private $bankId;
    
    public function __construct($adress,$bankId){
    
        $this->adress= $adress;
        $this->bankId = $bankId;
       
    
    }
    
    
 
    public function getAtmAdress(){
        return $this->adress;
    }



    public function setAdress($adress){
        $this->adress = $adress;
    }

public function getBankId(){
    return $this->bankId;
}



}



?>
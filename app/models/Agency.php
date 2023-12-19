<?php
require_once("../repositories/Database.php");



Class Agency{


    private $agencyId;
    private $longitude;
    private $latitude;
    private $agencyName;
    private $bankId;
    private $adressId;

    



    public function __construct($longitude,$latitude,$bankId,$agencyName,$adressId){
        // $this->agencyId = $agencyId;
        $this->longitude= $longitude;
        $this->latitude = $latitude ;
        $this->bankId = $bankId;
        $this->agencyName = $agencyName ;
        $this->adressId = $adressId;
        


    }




    public function getagencyId(){
        return $this->agencyId;
    }
    
    public function getlongitude(){
        return $this->longitude;
    }
    public function setlongitude($longitude){
        $this->longitude = $longitude;
    }
    public function getlatitude(){
        return $this->latitude;
    }
    public function setlatitude($latitude){
        $this->latitude = $latitude;
    }
    public function getagencyName(){
        return $this->agencyName;
    }
    public function setagencyName($agencyName){
        $this->agencyName = $agencyName;
    }
    public function getadressId(){
        return $this->adressId;
    }
    public function getBankId(){
        return $this->bankId;
    }
   
    }
    

?>

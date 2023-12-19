<?php
require_once("../repositories/Database.php");


Class User{

    private $userId;
    private $username;
    private $nom;
    private $prenom;
    private $password;
    private $adressId;

    private $agencyId;
    
    public function __construct($password,$prenom,$nom,$username,$adressId,$agencyId){
        $this->username= $username;
        $this->nom = $nom ;
        $this->prenom = $prenom;
        $this->password = $password ;
        $this->adressId = $adressId;
        $this->agencyId = $agencyId;

    }



    public function getuserId(){
        return $this->userId;
    }
    
    public function getusername(){
        return $this->username;
    }
    public function setusername($username){
        $this->username = $username;
    }
    public function getnom(){
        return $this->nom;
    }
    public function setnom($nom){
        $this->nom = $nom;
    }
    public function getprenom(){
        return $this->prenom;
    }
    public function setprenom($prenom){
        $this->prenom = $prenom;
    }
    public function getpassword(){
        return $this->password;
    }
    public function setpassword($password){
        $this->password = $password;
    }
    
    public function getadressId(){
        return $this->adressId;
    }

    public function getAgencyId(){
        return $this->agencyId;
    }
}



?>



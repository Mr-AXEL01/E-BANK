<?php



Class Adress{

    private $adressId;
    private $ville;
    private $rue;
    private $quartier;
    private $codePostal;
    private $email;

    private $tel;
    

    public function __construct($ville,$rue,$quartier,$codePostal,$email,$tel){
        // $this->adressId = $adressId;
        $this->ville= $ville;
        $this->rue = $rue;
        $this->quartier = $quartier ;
        $this->codePostal = $codePostal;
        $this->email = $email;
        $this->tel = $tel ;

    }



    public function getadressId(){
        return $this->adressId;
    }
    
    public function getville(){
        return $this->ville;
    }
    public function setville($ville){
        $this->ville = $ville;
    }
    public function getRue(){
        return $this->rue;
    }
    public function setRue($rue){
        $this->rue = $rue;
    }
    public function getquartier(){
        return $this->quartier;
    }
    public function setquartier($quartier){
        $this->quartier = $quartier;
    }
    public function getcodePostal(){
        return $this->codePostal;
    }
    public function setcodePostal($codePostal){
        $this->codePostal = $codePostal;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function getTel(){
        return $this->tel;
    }
    public function settel($tel){
        $this->tel = $tel;
    }
    

}



?>



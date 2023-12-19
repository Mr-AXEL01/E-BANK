<?php
require("../repositories/Database.php");



Class Bank{


private $bankId;
private $bankName;
private $logo;

public function __construct($logo,$name){

    $this->bankName= $name;
    $this->logo = $logo ;
   

}


public function getbankId(){
    return $this->bankId;
}

public function getbankName(){
    return $this->bankName;
}
public function setbankName($bankName){
    $this->bankName = $bankName;
}
public function getlogo(){
    return $this->logo;
}
public function setlogo($logo){
    $this->logo = $logo;
}


}


?>
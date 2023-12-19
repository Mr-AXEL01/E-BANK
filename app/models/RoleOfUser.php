<?php

require_once("../repositories/Database.php");

        class roleOfUser{

            private $roleOfUser;
            private $userId;
public function __construct($userId,$roleOfUser){
    $this->userId = $userId;
    $this->roleOfUser = $roleOfUser;

}
            public function getRoleOfUser(){
                return $this->roleOfUser;
            }
            public function setRoleOfUser($roleOfUser) {
                $this->roleOfUser = $roleOfUser;
            }
            public function getuserId(){
                return $this->userId;

            }
        }
        
       

?>
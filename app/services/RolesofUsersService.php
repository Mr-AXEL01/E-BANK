<?php
require_once("../repositories/Database.php");
require("RolesofUsersServiceInterface.php");

class RolesofUsersServices extends Database implements RoleofuserInterface
{

    protected $db;


    public function addRolesofuser(roleOfUser $roleOfuser)
    {

        $db = $this->connect();

        // $agencyId = $agency->getagencyId();
        $rolename = $roleOfuser->getRoleOfUser();
        $userId = $roleOfuser->getuserId();
  
       
       


 
        $addag = "INSERT INTO roleofuser (userId,rolename)  VALUES ( :userId,:rolename)";
        $stmt = $db->prepare($addag);
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":rolename", $rolename);
        
      

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}

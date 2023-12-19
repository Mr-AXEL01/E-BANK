<?php
require_once("../repositories/Database.php");
require("UserServiceInterface.php");

class Userservice extends Database implements UserInterface
{

    protected $db;


    public function addUser(Users $users)
    {

        $db = $this->connect();

        // $agencyId = $agency->getagencyId();
        $userName = $users->getusername();
        $nom = $users->getnom();
        $prenom = $users->getprenom();
        $password = $users->getpassword();
        $adressId = $users->getadressId();
       $agencyId = $users->getAgencyId();
       


 
        $addag = "INSERT INTO users (pw,firstName,familyName,username,adrId,agencyId)  VALUES ( :pw,:firstName,:familyName,:username,:adrId,:agencyId)";
        $stmt = $db->prepare($addag);
        $stmt->bindParam(":pw", $password);
        $stmt->bindParam(":firstName", $prenom);
        $stmt->bindParam(":familyName", $nom);
        $stmt->bindParam(":username", $userName);
        $stmt->bindParam(":adrId", $adressId);
        $stmt->bindParam(":agencyId", $agencyId);
      

        try {
            $stmt->execute();
           $userId = $db->lastInsertId();

            return $userId;
        } catch (PDOException $e) {
            die($e->getMessage());
        }

    }
    public function getUser()
    {
        $db = $this->connect();

        $query   = "SELECT * FROM users";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getFilteredUsers($id)
    {
        $db = $this->connect();
    
        $query = "SELECT u.*, a.agencyId, a.agencyName
                  FROM users u
                  JOIN agency a ON a.agencyId = u.agencyId
                  WHERE u.agencyId = :id";
    
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $result;
    }
    
    public function showeditduser($id){
       

        $db = $this->connect();
        $usersInfo = "SELECT users.*, adress.*, rolename
            FROM users 
            JOIN adress  ON users.adrId = users.adrId
            JOIN roleofuser ON users.userId = roleofuser.userId
            WHERE users.userId = :id";

$getuser = $db->prepare($usersInfo);
$getuser->bindParam(':id', $id, PDO::PARAM_INT);
$getuser->execute();
$result = $getuser->fetch(PDO::FETCH_ASSOC);




	
            $username = $result['username'];
            $firstname = $result['firstName'];
            $lastname = $result['familyName'];
            $password = $result['pw'];
            $ville = $result['ville'];
            $rue = $result['rue'];
            $quartier = $result['quartier'];
            $codePostal = $result['codepostale'];
            $email = $result['email'];
            $tel = $result['tel'];
            $userId = $result['userId'];
        

        
            return [$username, $firstname,$lastname,$password,$password,$ville,$rue,$quartier,$codePostal,$email,$tel,$userId];
    
}



public function editdUser(Users $users,adress $adress, $id){
    $db = $this->connect();

    $username = $users->getusername();
    $firstName = $users->getprenom();
    $familyName = $users->getnom();
    $pw = $users->getpassword();
    $ville = $adress->getville();
    $rue = $adress->getRue();
    $quartier = $adress->getquartier();
    $codepostale = $adress->getcodePostal();
    $email = $adress->getEmail();
    $tel = $adress->getTel();



    $updateQuery = "UPDATE users
    JOIN adress ON users.adrId = adress.adrId
    SET 
    users.username = :username,
    users.firstName = :firstName,
    users.familyName = :familyName,
    users.pw = :pw,
    adress.ville = :ville,
    adress.rue = :rue,
    adress.quartier = :quartier,
    adress.codepostale = :codePostal,  
    adress.email = :email,
    adress.tel = :tel
    WHERE 
        users.userId = :id;
    ";

    $stmt = $db->prepare($updateQuery);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":firstName", $firstName);
    $stmt->bindParam(":familyName", $familyName);
    $stmt->bindParam(":pw", $pw);
    $stmt->bindParam(":ville", $ville);
    $stmt->bindParam(":rue", $rue);
    $stmt->bindParam(":quartier", $quartier);
    $stmt->bindParam(":codePostal", $codepostale);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":tel", $tel);

    $stmt->bindParam(":id", $id, PDO::PARAM_INT); 

    try {
        $stmt->execute();
        
    } catch (PDOException $e) {
        die($e->getMessage());
    }

    header('location: Users.php');
}
}

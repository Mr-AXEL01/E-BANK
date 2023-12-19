<?php
require_once("../repositories/Database.php");
require_once("../models/Agency.php");
require("AgencyInterfaceService.php");

class Agencyservice extends Database implements AgencyInterface
{

    protected $db;


    public function addAgency(Agency $agency)
    {

        $db = $this->connect();

        // $agencyId = $agency->getagencyId();
        $longitude = $agency->getlongitude();
        $latitude = $agency->getlatitude();
        $agencyName = $agency->getagencyName();
        $adrId = $agency->getadressId();
        $bankId = $agency->getBankId();



 
        $addag = "INSERT INTO agency (longitude , latitude,bankId,agencyName,adrId)  VALUES ( :longitude, :latitude,:bankId,:agencyname,:adrId)";
        $stmt = $db->prepare($addag);
        // $stmt->bindParam(":agencyId", $agencyId);
        $stmt->bindParam(":longitude", $longitude);
        $stmt->bindParam(":latitude", $latitude);
        $stmt->bindParam(":bankId", $bankId);
        $stmt->bindParam(":agencyname", $agencyName);
        $stmt->bindParam(":adrId",$adrId);


        try {
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getAgency()
    {
        $db = $this->connect();

        $query   = "SELECT * FROM agency WHERE deletedAg = FALSE ";

        $getAgency = $db->query($query);
        $result = $getAgency->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    public function getFiltredAgency($id)
    {
        $db = $this->connect();

        $query   = "SELECT a.* ,b.bankId , b.logo 
        FROM agency a
        JOIN bank b ON a.bankId = b.bankId
        WHERE a.bankId = $id
        
        ";

        $getAgency = $db->query($query);
        $result = $getAgency->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    public function showeditdAgency($id){
       

        $db = $this->connect();
        $Agencyinfo = "SELECT agency.*, adress.*, bank.bankId
            FROM agency 
            JOIN adress  ON agency.adrId = adress.adrId
            JOIN bank  ON agency.bankId = bank.bankId
            WHERE agency.agencyId = :id";

$getagency = $db->prepare($Agencyinfo);
$getagency->bindParam(':id', $id, PDO::PARAM_INT);
$getagency->execute();
$result = $getagency->fetch(PDO::FETCH_ASSOC);




          $AgencyName = $result['agencyName'];
            $Longitude = $result['longitude'];
            $Latitude = $result['latitude'];
            $ville = $result['ville'];
            $rue = $result['rue'];
            $quartier = $result['quartier'];
            $codePostal = $result['codepostale'];
            $email = $result['email'];
            $tel = $result['tel'];
            $bankId = $result['bankId'];
            $agencyId = $result['agencyId'];

        

        
            return [$AgencyName, $Longitude,$Latitude,$ville,$rue,$quartier,$codePostal,$email,$tel,$bankId,$agencyId];
    
}

public function editdAgency(agency $agency,adress $adress, $id){
    $db = $this->connect();

    $agencyName = $agency->getagencyName();
    $longitude = $agency->getlongitude();
    $latitude = $agency->getlatitude();
    $bankId = $agency->getBankId();
    $ville = $adress->getville();
    $rue = $adress->getRue();
    $quartier = $adress->getquartier();
    $codepostale = $adress->getcodePostal();
    $email = $adress->getEmail();
    $tel = $adress->getTel();



    $updateQuery = "UPDATE agency
    JOIN adress ON agency.adrId = adress.adrId
    JOIN bank ON agency.bankId = bank.bankId
    SET 
    agency.agencyName = :agencyName,
    agency.longitude = :longitude,
    agency.latitude = :latitude,
    adress.ville = :ville,
    adress.rue = :rue,
    adress.quartier = :quartier,
    adress.codepostale = :codePostal,  
    adress.email = :email,
    adress.tel = :tel
    WHERE 
        agency.agencyId = :id;
    ";

    $stmt = $db->prepare($updateQuery);
    $stmt->bindParam(":agencyName", $agencyName);
    $stmt->bindParam(":longitude", $longitude);
    $stmt->bindParam(":latitude", $latitude);
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

    header('location: agency.php');
}

public function SoftDelete($id) {

    $db = $this->connect();

    $soft_delete = "UPDATE agency set deletedAg	 = TRUE WHERE agencyId = :id";

    $stmt = $db->prepare($soft_delete);
    $stmt->bindParam(":id", $id);
    $stmt->execute();


}public function restAgency() {

    $db = $this->connect();

    $deleteAll = "UPDATE agency set deletedAg = FALSE ;";

    $stmt = $db->prepare($deleteAll);
   
    $stmt->execute();


}

}?>
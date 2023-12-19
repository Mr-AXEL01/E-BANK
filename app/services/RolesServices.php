
<?php
require_once("../repositories/Database.php");
require("roleServiceInterface.php");

class RoleService extends Database implements RoleInterface
{

    protected $db;



    public function selectRoles()
    {
        $db = $this->connect();

        $query   = "SELECT rolename FROM roles";

        $getrolename = $db->query($query);
        $result = $getrolename->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}

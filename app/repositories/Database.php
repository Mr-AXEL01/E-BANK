<?php

require("../config/config.php");

class Database{

protected $db;

public function connect(){

    try {
        $db =new PDO("mysql:host=" .HOST.";dbname=" . DB ,USER , PASSWORD);
        return $db; 
    } catch (PDOException $e) {
        $e->getMessage();
    }

}

}



?>
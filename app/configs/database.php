<?php

require('config.php');

// try {
// $conn = new PDO("mysql:host=". HOST, USER , PASSWORD);
// $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// $sql="CREATE DATABASE IF NOT EXISTS `". DB ."`";
// $conn->exec($sql);
// $conn->exec("USE `". DB ."`");
// echo "Database created or already exists. <br/>";
// }catch (PDOException $e) {
//     echo $sql . "<br/>" . $e->getMessage();
// }

try {
    $conn = new PDO("mysql:host=". HOST .";dbname=" . DB , USER , PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connected seccessfully. <br/>";
    }catch (PDOException $e) {
        echo $sql . "<br/>" . $e->getMessage();
    }
    
?>
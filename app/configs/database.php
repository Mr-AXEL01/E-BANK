<?php

require('config.php');


try {
$conn = new PDO("mysql:host=". HOST .";dbname=" . DB , USER , PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo "Database connected seccessfully. <br/>";
}catch (PDOException $e) {
    echo $sql . "<br/>" . $e->getMessage();
}
?>
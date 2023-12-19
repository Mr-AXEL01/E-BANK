<?php

require("../repositories/Database.php");


        class Roles{

        private  $roleName;

        public function getroleName(){
            return $this->roleName;
        }
        public function setAgencyId($roleName){
            $this->roleName = $roleName;
        }
    }

?>
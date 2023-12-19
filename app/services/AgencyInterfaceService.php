<?php



interface AgencyInterface{
 
    public function addAgency(Agency $agency);

    
    public function getAgency();

    public function getFiltredAgency($id);

    public function showeditdAgency($id);
    public function SoftDelete($id);
}


?>
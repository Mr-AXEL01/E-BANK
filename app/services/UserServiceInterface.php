<?php



interface UserInterface{
 
    public function addUser(Users $users);

    public function getUser();
   
    public function getFilteredUsers($id);
}


?>
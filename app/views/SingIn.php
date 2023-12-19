<?php
require_once "../models/Adress.php";
require_once "../services/AdressService.php";
require_once "../models/User.php";
require_once "../services/UserServices.php";
require_once "../services/RolesServices.php";
require_once "../models/RoleOfUser.php";
require_once "../services/AgencyService.php";

require_once "../services/RolesofUsersService.php";
$UsersService = new Userservice();
if (isset($_POST["submit"])) {
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $Cpassword = $_POST['Cpassword'];
    $ville = $_POST['ville'];
    $rue = $_POST['rue'];
    $quartier = $_POST['quartier'];
    $codePostal = $_POST['codePostal'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $agencyId = $_POST['agencyId'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $error = array();
    if ($password === $Cpassword) {
        $Adress = new Adress($ville, $rue, $quartier, $codePostal, $email, $tel);
        $bankService = new AdressService();
        $adrId =  $bankService->addAdress($Adress);




        $Users = new Users($hashedPassword, $firstname, $lastname, $username, $adrId,$agencyId);
       
        $userId = $UsersService->addUser($Users);

        $selectedRoles = isset($_POST['user-type']) ? $_POST['user-type'] : array();
        foreach ($selectedRoles as $selectedRole) {

            $roleofuser = new roleOfUser($userId, $selectedRole);
            $rolenameservice = new RolesofUsersServices();
            $rolenameservice->addRolesofuser($roleofuser);
        }
    } else {
        $error[] = 'Password and confirmation password do not match!';
    }
}
if (isset($_POST["operation"]) && isset($_POST["editing"])) {
    $id = $_POST["userid"];

    [$username, $firstname,$lastname,$password,$password,$ville,$rue,$quartier,$codePostal,$email,$tel,$userId] =  $UsersService->showeditduser($id);
}

if (isset($_POST['edited'])) {
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $Cpassword = $_POST['Cpassword'];
    $ville = $_POST['ville'];
    $rue = $_POST['rue'];
    $quartier = $_POST['quartier'];
    $codePostal = $_POST['codePostal'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $id = $_POST["userid"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $adrId = '';
    $agencyId ='';
    if ($password === $Cpassword) {
        $Adress = new Adress($ville, $rue, $quartier, $codePostal, $email, $tel);
 
        $Users = new Users($hashedPassword, $firstname, $lastname, $username, $adrId,$agencyId);
        $UsersService->editdUser($Users,$Adress,$id);


}
}
$agencyService = new Agencyservice();
$agencys = $agencyService->getAgency();

$RolesService = new RoleService();
$rolenames = $RolesService->selectRoles();
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Document</title>
</head>

<body>
    <section class="h-[100vh] w-[100%] flex items-center">

        <form class="w-[50%] mx-auto" method="post" action="">
            <?php
            if (isset($error)) {
                foreach ($error as $errorMessage) {
                    echo '<p style="color: red;">' . $errorMessage . '</p>';
                }
            }
            ?>
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="username" value="<?= $username ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_repeat_password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Username</label>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="firstname" value="<?= $firstname ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">FirstName</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="lastname" value="<?= $lastname ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="floating_last_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">LastName</label>
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input type="password" name="password" value="<?= $password ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="password" name="Cpassword" value="<?= $password ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="floating_last_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirme Password</label>
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="ville" value="<?= $ville ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">User City</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="rue" value="<?= $rue ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="floating_last_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">User Street</label>
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="quartier" value="<?= $quartier ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">User neighborHood</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="codePostal" value="<?= $codePostal ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="floating_last_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">User PostalCode</label>
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input type="email" name="email" value="<?= $email ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">User E-mail</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="tel" value="<?= $tel ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="floating_last_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">User Phone</label>
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="w-[100%] ">
                    <?php
                    if (isset($_POST["operation"]) && isset($_POST["editing"])) {
                    }else{
                            foreach ($rolenames as $rolename) :

                    ?>
                        <label>
                            <input type="checkbox" name="user-type[]" value="<?= $rolename["rolename"] ?> " class="mr-2">
                            <?= $rolename["rolename"] ?> </label>

                    <?PHP endforeach; 
                    }?>


                

                </div>
                <?php
                    if (isset($_POST["operation"]) && isset($_POST["editing"])) {
                    }else{
                          ?>
                <select name="agencyId" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    <option value="">Choses Agency</option>
                    <?php
                    foreach ($agencys as $agency) : ?>
                        <option value="<?php echo  $agency['agencyId'] ?>"><?php echo $agency['agencyName'] ?></option>

                    <?php endforeach; } ?>



                </select>
            </div>



            <input type="hidden" name="userid" value="<?= $userId ?>">

            <?php
                if (isset($_POST['userid'])) {
                    
                    echo '<input type="submit" name="edited" value="Edit"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >';
                } else {
                    echo '<input type="submit" name="submit" value="Add Bank"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >';
                };
                ?>        </form>

    </section>
</body>

</html>
<?php
require_once "../models/Adress.php";
require_once "../services/AdressService.php";
require_once "../models/Agency.php";  
require_once "../services/BankService.php";
require_once "../services/AgencyService.php";  
$agencyService = new AgencyService();
$bankService = new AdressService();

if (isset($_POST["submit"])){
    $AgencyName = $_POST['AgencyName'];
    $Longitude = $_POST['Longitude'];
    $Latitude = $_POST['Latitude'];
    $ville = $_POST['ville'];
    $rue = $_POST['rue'];
    $quartier = $_POST['quartier'];
    $codePostal = $_POST['codePostal'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $bankId = $_POST['bankid'];

    $Adress = new Adress( $ville, $rue, $quartier, $codePostal, $email, $tel);
    $bankService = new AdressService();
   $adrId =  $bankService->addAdress($Adress);
   

    $agency = new Agency( $Longitude, $Latitude, $bankId, $AgencyName, $adrId);
    $agencyService->addAgency($agency);

}

$AgencyName = $Longitude = $Latitude = $ville = $rue = $quartier = $codePostal = $email = $tel = $bankId = "";
if (isset($_POST["operation"]) && isset($_POST["editing"])) {
    $id = $_POST["agencyid"];

    [$AgencyName, $Longitude,$Latitude,$ville,$rue,$quartier,$codePostal,$email,$tel,$bankId,$agencyId] =  $agencyService->showeditdAgency($id);
}
$adrId = '';
$bankId ='';
if (isset($_POST['edited'])) {
    $AgencyName = $_POST['AgencyName'];
    $Longitude = $_POST['Longitude'];
    $Latitude = $_POST['Latitude'];
    $ville = $_POST['ville'];
    $rue = $_POST['rue'];
    $quartier = $_POST['quartier'];
    $codePostal = $_POST['codePostal'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $bankId = $_POST['bankid'];
    $id = $_POST["agencyId"];


    $agency = new agency( $Longitude, $Latitude,$bankId,$AgencyName,$adrId);
    $adress = new adress( $ville, $rue,$quartier,$codePostal,$email,$tel);

    
    $agencyService->editdAgency($agency,$adress,$id);

}





$banksService = new Bankservice();
$banks = $banksService->getBanks();
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
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="AgencyName" value="<?= $AgencyName ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Agency Name</label>

            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="Longitude" value="<?= $Longitude ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Longitude</label>

            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="Latitude" value="<?= $Latitude ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_repeat_password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Latitude</label>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="ville" value="<?= $ville ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Agency City</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="rue" value="<?= $rue ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="floating_last_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Agency Street</label>
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="quartier" value="<?= $quartier ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Agency neighborHood</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="codePostal" value="<?= $codePostal ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="floating_last_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Agency PostalCode</label>
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input type="email" name="email" value="<?= $email ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Agency E-mail</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="tel" value="<?= $tel ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="floating_last_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Agency Phone</label>
                </div>
            </div>
            <div class="grid md:grid-cols-1 ">
            <select name="bankid"  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
            <option value="">Choses Bank</option>
            <?php
            foreach($banks as $bank):?>
    <option value="<?php echo  $bank['bankId'] ?>"><?php echo $bank['bankName'] ?></option>

         <?php   endforeach;?>
      
            
            
            </select>
            </div>
           

            <input type="hidden" name="agencyId" value="<?= $agencyId ?>">

            <?php
                if (isset($_POST['agencyid'])) {
                    
                    echo '<input type="submit" name="edited" value="Edit"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >';
                } else {
                    echo '<input type="submit" name="submit" value="Add Agency"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >';
                };
                ?>        </form>

    </section>
</body>

</html>
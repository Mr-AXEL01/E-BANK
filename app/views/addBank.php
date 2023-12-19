<?php
require_once "../models/Bank.php";
require_once "../services/BankService.php";




if (isset($_POST["submit"])){
    $logo = $_POST['logobank'];
    $bankname = $_POST['bankName'];
 

    $Bank = new Bank( $logo, $bankname);
    $bankService = new Bankservice();
     $bankService->addBank($Bank);

}
 $logo ='';
    $name = '';
if (isset($_POST["operation"]) && isset($_POST["edit"])) {
    $id = $_POST["bankid"];

$bankService = new Bankservice();
[$logo, $name,$bankId] = $bankService->showeditdbank($id);

}
   
if (isset($_POST['edited'])) {
    $logo = $_POST['logobank'];
    $name = $_POST['bankName'];
    $id = $_POST['bankid'];

    $Bank = new Bank( $logo, $name);
    $bankService = new Bankservice();
    $bankService->editdBank($Bank,$id);

}

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
    <section class="h-screen w-full flex items-center">

        <form class="w-[50%] mx-auto" method="post" action="">
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="logobank" id="floating_password" value="<?= $logo ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Bank Logo</label>

            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="bankName" id="floating_password" value="<?= $name ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Bank Name</label>

            </div>
       

            <input type="hidden" name="bankid" value="<?= $bankId ?>">

           <?php
                if (isset($_POST['bankid'])) {
                    
                    echo '<input type="submit" name="edited" value="Edit"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >';
                } else {
                    echo '<input type="submit" name="submit" value="Add Bank"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >';
                };
                ?>
        </form>

    </section>
</body>

</html>
<?php

require_once "../services/AgencyService.php";


$agenteService = new Agencyservice();

if (isset($_POST['deleteagency']) && isset($_POST['delete'])) {
    $id = $_POST['delete'];

   
$agenteService->SoftDelete($id);
     
}
if (isset($_POST['reset'])) {
   $agenteService->restAgency();
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
    <title>Gestionaire Bancaire</title>
    <style>
        header {
            filter: drop-shadow(4px 4px 5px rgba(255, 255, 255));
            border: 1px white solid;
        }
    </style>
</head>

<body class="bg-gray-100  bg-cover">
    <header class="header sticky h-[12vh]  top-0 bg-white shadow-md flex items-center justify-between px-8 py-02 z-50 	">
        <a href="" class="flex items-center font-bold text-blue-950	gap-[7px]">
            <img src="images/CentralLogo.png" alt="" class="md:h-[60px] md:w-[150px] h-[35px] w-[90px]">
            ADMIN
        </a>
        <nav class="nav font-semibold w-[100%] text-lg">
            <ul class="flex items-center w-[100%] justify-center  ">

                <li class="p-4 border-b-2 border-blue-500 border-opacity-0 hover:border-opacity-100 hover:text-blue-500 duration-200 cursor-pointer">
                    <select name="clients" id="selectOption" class="outline-none rounded">
                        <option class="font-semibold text-lg" value="Banks">Locations</option>

                        <option class="font-semibold text-lg" value="Banks">Banks</option>
                        <option class="font-semibold text-lg" value="agency">agency</option>
                        <option class="font-semibold text-lg" value="ATM">ATM</option>
                    </select>
                </li>

                <li class="p-4 border-b-2 border-blue-500 border-opacity-0 hover:border-opacity-100 hover:text-blue-500 duration-200 cursor-pointer">
                    <select name="clients" id="selectOptions1" class="outline-none rounded">
                        <option class="font-semibold text-lg" value="client">Operations</option>

                        <option class="font-semibold text-lg" value="client">Users</option>
                        <option class="font-semibold text-lg" value="accounts">accounts</option>
                        <option class="font-semibold text-lg" value="transactions">transactions</option>
                    </select>
                </li>
                <li class="p-4 border-b-2 border-red-500 border-opacity-0 hover:border-opacity-100 hover:text-red-500 duration-200 cursor-pointer">
                    <a href="index.php" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">Log Out</a>
                </li>
            </ul>
        </nav>

    </header>
    <script src="navbar.js"></script>

    <script src="navbar.js">

    </script>
    <div class="flex justify-evenly items-center  h-[20vh] ">
        <h1 class="text-[50px]    text-black">AGENCIES</h1>
        <a href="addAgency.php" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 border border-blue-600 rounded">ADD AGENCIES</a>

    </div>
    <section class="min-h-[75vh]">



<?php
        if (isset($_POST['submit']) && isset($_POST['bankid'])) {
            $bankid = $_POST['bankid'];

         $agencyBank =   $agenteService->getFiltredAgency($bankid);
            foreach ($agencyBank as $agency) {
                ?>

        <div class='flex w-full  justify-center h-[60px]  items-center text-black'>
            <img class=' w-[15%] h-[100%] flex items-center  justify-center' src='<?= $agency["logo"] ?>'>
        </div>


        <table class=" w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">';
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">ID</th>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Longitude</th>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Latitude</th>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Agency Name</th>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Bank ID</th>

                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Edit</th>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Delete</th>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Users</th>
                            </tr>
                        </thead>


                    <td class='px-6 py-4 font-semibold text-center'><?= $agency["agencyId"] ?></td>
                    <td class='px-6 py-4 font-semibold text-center'> <?= $agency["longitude"] ?></td>
                    <td class='px-6 py-4 font-semibold text-center'> <?= $agency["latitude"] ?> </td>
                    <td class='px-6 py-4 font-semibold text-center'><?= $agency["agencyName"] ?></td>
                    <td class='px-6 py-4 font-semibold text-center'><?= $agency["bankId"] ?></td>


    
                            <td >
                            <form action='addagency.php' method='POST' class=' cursor-pointer text-center focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900'>
                            <input type='hidden'  name='operation' value='<?= $agency["agencyId"] ?>'>
                            <input type='hidden' name='agencyid' value='<?= $agency["agencyId"] ?>'>
                            <input type='submit'   name='editing' value='Edit' class='cursor-pointer'>
                        </form>
                        
                            </td>

                            <td >
                                <form action='agency.php' method='post' class=' cursor-pointer text-center focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900'>
                                    <input type='hidden' name='delete' value='<?= $agency["agencyId"] ?>'>
                                    <input type='submit'  name='deleteagency' value='Delete' class='cursor-pointer'>
                                </form>
                            </td>



                        
                       
                         
                         
                            <td >
                            <form action='users.php' method='post'  class=' cursor-pointer text-center focus:outline-none text-white bg-gray-500 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-900'>
                                <input type='hidden' name='agencyId' value='<?= $agency["agencyId"] ?>'>
                                <input type='submit'  name='users' value='Show' class='cursor-pointer'>
                            </form>
                        </td>
                        </tr>
                        <?php
            }

}else{ 
?>
                
                </table>
  
             
       

    
                <table id = "dataTable" class=" w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">';
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">ID</th>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Longitude</th>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Latitude</th>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Agency Name</th>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Bank ID</th>

                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Edit</th>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Delete</th>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Users</th>
                            </tr>
                        </thead>
                    <?php   $agencyBank =   $agenteService->getAgency();
            foreach ($agencyBank as $agency) {
                ?>

                   
<td class='px-6 py-4 font-semibold text-center'><?= $agency["agencyId"] ?></td>
                    <td class='px-6 py-4 font-semibold text-center'> <?= $agency["longitude"] ?></td>
                    <td class='px-6 py-4 font-semibold text-center'> <?= $agency["latitude"] ?> </td>
                    <td class='px-6 py-4 font-semibold text-center'><?= $agency["agencyName"] ?></td>
                    <td class='px-6 py-4 font-semibold text-center'><?= $agency["bankId"] ?></td>


    
                            <td >
                            <form action='addagency.php' method='post' class=' cursor-pointer text-center focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900'>
                            <input type='hidden'  name='operation' value='<?= $agency["agencyId"] ?>'>
                            <input type='hidden' name='agencyid' value='<?= $agency["agencyId"] ?>'>
                            <input type='submit'   name='editing' value='Edit' class='cursor-pointer'>
                        </form>
                        
                            </td>

                            <td >
                                <form action='agency.php' method='post' class=' cursor-pointer text-center focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900'>
                                    <input type='hidden' name='delete' value='<?= $agency["agencyId"] ?>'>
                                    <input type='submit'  name='deleteagency' value='Delete' class='cursor-pointer'>
                                </form>
                            </td>



                        
                       
                         
                         
                            <td >
                            <form action='users.php' method='post'  class=' cursor-pointer text-center focus:outline-none text-white bg-gray-500 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-900'>
                                <input type='hidden' name='agencyId' value='<?= $agency["agencyId"] ?>'>
                                <input type='submit'  name='users' value='Show' class='cursor-pointer'>
                            </form>
                        </td>
                        </tr>
                <?php
            }

        }
?>
        </table> 



        <form method="post" class="w-[100%] flex justify-center items-center h-[15vh] ">
            <input value="RESET" type="submit" name="reset" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"></input>
        </form>
        <div class="flex justify-center items-center mt-10">




        </div>

    </section>

    <footer class="text-center h-[5vh] text-white bg-black flex items-center justify-center">
        <h2>Copyright © 2030 Hashtag Developer. All Rights Reserved</h2>
    </footer>


</body>

</html>
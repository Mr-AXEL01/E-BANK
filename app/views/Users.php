


<?php
require_once("../services/UserServices.php");
$Usersservice = new Userservice();
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

<body class ="bg-gray-100  bg-cover">
        <header class="header sticky w-[100%] top-0 bg-white shadow-md flex items-center justify-between px-8 py-02 z-50 	">
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
            <form action="users.php" method="post" class="flex items-center mr-[10px]">
                <input type="text" name="search" placeholder="Search UserName..." class="p-2 border border-gray-300 rounded-md" >
            </form>
        </header>
        <script src="navbar.js"></script>

        </script>

        <div class="flex justify-evenly items-center mb-[50px]">
            <h1 class="text-[50px] h-[10%]  text-center text-black">USERS</h1>
            <a href="registre.php" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 border border-blue-600 rounded">Add USERS</a>

        </div>
        <section class="min-h-[75vh]">

        <div >


        
        <?php
        if (isset($_POST['agencyId']) ) {
            $agencyId = $_POST['agencyId'];

         $UsersAgency =   $Usersservice->getFilteredUsers($agencyId);
            foreach ($UsersAgency as $Users) {
             
                ?>




             <div class ='flex w-[100%]  justify-center h-[60px]  items-center text-black'>

                   <p class=' w-[50%] h-[100%] flex items-center  justify-center'>Agence : <?= $Users["agencyName"] ?></p>
               </div>
                






                    <table  class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
           <thead class="text-xs text-gray-700 upper w-[11%] px-6 py-3 text-center" scope="col" >
                        <tr>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">User Name</th>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">First Name</th>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Family Name</th>
                            
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Editing</th>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Deleting</th>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Accounts</th>
                            </tr>
                        </thead>
                   

               <tr> 
                                <td class='px-6 py-4 font-semibold text-center'><?= $Users["username"] ?></td>
                                <td class='px-6 py-4 font-semibold text-center'> <?= $Users["firstName"] ?></td>
                                <td class='px-6 py-4 font-semibold text-center'><?= $Users["familyName"] ?></td>
                            
                                
                        
                        
                            
                            <td >
                                <form action='SingIn.php' method='post'  class=' cursor-pointer text-center focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900'>
                                <input type='hidden' name='operation' value='<?= $Users["userId"] ?>'>
                                <input type='hidden' name='userid' value='<?= $Users["userId"] ?>'>
                                <input type='submit'  name='editing' value='Edit' class=' cursor-pointer'>
                            </form>
                            
        
                            
                                </td>
                            <td >
                            <form action='users.php' method='post' class=' cursor-pointer text-center focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900'>
                            <input type='hidden' name='userid' value='<?= $Users["userId"] ?>'>
                            <input type='submit'  name='deleteuser' value='Delete' class=' cursor-pointer'>
                        </form>
                        
                                </td>
                                <td >
                                <form action='agences.php' method='post' class=' cursor-pointer text-center focus:outline-none text-white bg-gray-500 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-900'>
                                    <input type='hidden' name='userid' value='<?= $Users["userId"] ?>'>
                                    <input type='submit'  name='submit' value='Show' class=' cursor-pointer'>
                                </form>
                            </td> 
                            </tr>
                            <?php
            }

}else{ 
?>
            </table>
          
       
       
           
          

                    <table id="dataTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 upper w-[11%] px-6 py-3 text-center" scope="col" >
                      <tr>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">User Name</th>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">First Name</th>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Family Name</th>
                            
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Editing</th>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Deleting</th>
                                <th class=" w-[11%] px-6 py-3 text-center" scope="col">Accounts</th>
                            </tr>
                        </thead>
                        <?php 
                     $UsersAgency =   $Usersservice->getUser();
                     foreach ($UsersAgency as $Users) {
                    
                    ?> 
                    <tbody class="h-[2vh] ">
                          <tr> 
                                <td class='px-6 py-4 font-semibold text-center'><?= $Users["username"] ?></td>
                                <td class='px-6 py-4 font-semibold text-center'> <?= $Users["firstName"] ?></td>
                                <td class='px-6 py-4 font-semibold text-center'><?= $Users["familyName"] ?></td>
                            
                                
                        
                        
                                <td >
                                <form action='SingIn.php' method='post'  class=' cursor-pointer text-center focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900'>
                                <input type='hidden' name='operation' value='<?= $Users["userId"] ?>'>
                                <input type='hidden' name='userid' value='<?= $Users["userId"] ?>'>
                                <input type='submit'  name='editing' value='Edit' class=' cursor-pointer'>
                            </form>
                            
        
                            
                                </td>
                            <td >
                            <form action='users.php' method='post' class=' cursor-pointer text-center focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900'>
                            <input type='hidden' name='userid' value='<?= $Users["userId"] ?>'>
                            <input type='submit'  name='deleteuser' value='Delete' class=' cursor-pointer'>
                        </form>
                        
                                </td>
                                <td >
                                <form action='agences.php' method='post' class=' cursor-pointer text-center focus:outline-none text-white bg-gray-500 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-900'>
                                    <input type='hidden' name='userid' value='<?= $Users["userId"] ?>'>
                                    <input type='submit'  name='submit' value='Show' class=' cursor-pointer'>
                                </form>
                            </td> 
                            </tr>
                            <?php
            }

        }
?>
                  </table>
                    
              
                
                    

        </div>
        
    </section>

    <footer class="text-center h-[5vh] text-white bg-black flex items-center justify-center">
        <h2>Copyright © 2030 Hashtag Developer. All Rights Reserved,</h2>
    </footer>

 


</body>

</html>
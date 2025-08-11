<?php
//establishing connection to database
   $server = 'localhost'; 
   $user = 'root'; 
   $password = '';
   $database = 'ar_shopping';

   $conn = mysqli_connect($server, $user, $password, $database); 

   if (!$conn) { 
       die('Database Connection failed: ' . mysqli_connect_error()); 
   }
?>
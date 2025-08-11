<?php
session_start();
require_once "php/dbaseCon.php";


if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: Index.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
    <nav class="navbar">
    <ul class="Navigation">
       <li><img class ="navbar-logo" src ="pictures/logo.png" alt=""></li> 
        <li class="nav-option" ><a class ="nav-links" href="Index.php">Home</a></li>
        <li class="nav-option"><a class ="nav-links" href="php/invalid.php">About</a></li>
        <li class="nav-option"><a class ="nav-links" href="php/invalid.php">Contact</a></li>
        <li class="nav-option"><a class ="nav-links" href="php/checkout.php">checkout</a></li>

        </ul>
                <?php if (isset($_SESSION['username'])) { 
                    echo '<a class="signup-btn" href="?logout=1">Logout</a>'; 
                } else { 
                    echo "<a class='signup-btn' href='php/login.php'>Login</a>
            <a class='signup-btn' href='PHP/Register.php'>Sign-Up</a>";
                } 
                ?>        </ul>
</nav>
                <?php
if (isset($_SESSION['userType'])) {
        if ($_SESSION['userType'] === 'users') {            
            $query = 'select * from products order by price desc';  //for users logged in as users
        } else{
            $query = 'select * from products order by price desc';  //for non reg users to still view items
        } }else {
            $query = 'select * from products order by price desc';  //for admins to view items
        }
    
    $result = null; 
    try { 
    $result = mysqli_query($conn, $query);  
    } catch (Exception $e){ 
    echo '<br><br>Error occurred: ' . mysqli_error($conn) . '<br><br>'; 
    echo "Please <a href=\"..\index.html\">return to form</a> to resubmit";  
    }

    
    if ($result) {  
        if (mysqli_num_rows($result) > 0) { 
            while ($row = mysqli_fetch_assoc($result)) {                 
                echo "
                <div class='products-container'>
                <div class= 'product'>
                    <img src='{$row['image']}'}' class='product-image' />
                    <p class='product-info'>Name: <span>{$row['name']}</span></p>
                    <p class='product-info'>Price: <span>$ {$row['price']}</span></p>
                    <p class='product-info'>Category: <span>{$row['category']}</span></p>
                    <p class='product-info'>Stock: <span>{$row['stock']}</span></p>
                    

                    <a href=\"php/productDetails.php?productID={$row['productID']}\" class='view-product'>View</a>

                    <a class='add-to-cart' href=\"php/addToCart.php?productID={$row['productID']}\" ><i class='fa-solid fa-cart-shopping'></i></a>
                    </div>
                </div>";
                
            }
        } else {
            echo "<br>Query executed. No records found ."; 
        }
    } 

    if (isset($_SESSION['userType']) && $_SESSION['userType'] === 'admin') {

    echo "<div class='product'>
     <a class = 'product-add' href='php/productUpload.php'>
     <i class='product-add fa-sharp fa-solid fa-plus'></i>
     <span>Add Product</span>
     </a>
     </div>";
    }
    mysqli_close($conn);
    ?>

</body>
</html>


<?php
session_start();
require_once "dbaseCon.php";

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../Index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>prod details</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>


    <nav class="navbar">
    <ul class="Navigation">
       <li><img class ="navbar-logo" src ="../pictures/logo.png" alt=""></li> 
        <li class="nav-option" ><a class ="nav-links" href="../Index.php">Home</a></li>
        <li class="nav-option"><a class ="nav-links" href="invalid.php">About</a></li>
        <li class="nav-option"><a class ="nav-links" href="invalid.php">Contact</a></li>
        <li class="nav-option"><a class ="nav-links" href="checkout.php">checkout</a></li>

        </ul>
                <?php if (isset($_SESSION['username'])) { 
                    echo '<a class="signup-btn" href="?logout=1">Logout</a>'; 
                } else { 
                    echo "<a class='signup-btn' href='login.php'>Login</a>
            <a class='signup-btn' href='Register.php'>Sign-Up</a>";
                } ?>
</nav>



    <?php
$productID = 'productID';
if (isset($_GET['productID'])) {
    $productID = $_GET['productID'];
}
$query = "select * from products where productID = '$productID'";

$result = null; 

try { 
  $result = mysqli_query($conn, $query);
} catch (Exception $e){
  echo '<br><br>Error occurred: ' . mysqli_error($conn) . '<br><br>';
} 

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "
            <div class='prod-details-container'>
                    <img src='{$row['image']}'}' class='product-image' />
                    <div class='prod-details'>
                        <p class='prod-detail'>Product Name: <span>{$row['name']}</span></p>
                        <p class='prod-detail'>Price: <span>$ {$row['price']}</span></p>
                        <p class='prod-detail'>category: <span>{$row['category']}</span></p>
                        <p class='prod-detail'>In Stock: <span>{$row['stock']}</span></p>
                        <p class='prod-detail description'>Description: <span>{$row['description']}</span></p>
                        <a class='prod-detail' href='addToCart.php?productID={$row['productID']}'><i class='fa-solid fa-cart-shopping'></i></a>

                </div>
            </div>";
        }
    }
}
    ?>
</body>
</html>
<?php
session_start();
require_once "dbaseCon.php";
$userID = $_SESSION['userID'];


if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../Index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
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
if (!isset($_SESSION['userID'])) {
    echo "<p>You must be logged in to view your cart. 
    <a href='../index.php'>Go Home</a></p>";
    exit;
}
$userID = $_SESSION['userID'];

$query = "select users.fullName, products.name, products.image, products.price, cart.quantity, cart.productID from cart join users ON cart.userID = users.userID join products
    on cart.productID = products.productID where cart.userID = '$userID'";
$result = mysqli_query($conn, $query);


if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "
        <div class='prod-details-cart'>
            <img src='{$row['image']}' class='product-image' />
            <div class='prod-cart'>
                <p class='prod-item'>Customer: <span>{$row['fullName']}</span></p>
                <p class='prod-item'>Product Name: <span>{$row['name']}</span></p>
                <p class='prod-item'>Price: <span>$ {$row['price']}</span></p>
                <p class='prod-item'>Quantity: <span>{$row['quantity']}</span></p>                
                <a href='removeItem.php?productID={$row['productID']}' class='delete-icon'><i class='fa-solid fa-trash'></i></a>
            </div>
        </div>";
    }
} else {
    echo "<p>No cart items found <a href='../index.php'>Go Home</a></p>";
}
echo"<div class='checkout-btn'>
    <a href='processCheckout.php?userID={$userID}' class='btn-checkout'>
        <i class='fa-solid fa-credit-card'></i> Proceed to Checkout
    </a>
</div>"
?>
</body>
</html>

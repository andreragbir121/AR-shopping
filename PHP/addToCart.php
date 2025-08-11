<?php
// starts the session
session_start();
// calls the script for establishing database connection
require_once "dbaseCon.php";
$userID = $_SESSION['userID'];

// destroys the entire session to if logout
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
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>


    
    <?php
    // jf not user is logged in or no items added to cart print msg
if (!isset($_SESSION['userID']) || !isset($_GET['productID'])) {
    echo "No logged in user or missing cart item.";
    exit;
}
// declare the product id var
$productID = $_GET['productID'];

// sql query for selecting from the cart based on the user id and prod id
$query = "select * from cart where userID = '$userID' and productID = '$productID'";
$results = mysqli_query($conn, $query);

if ($results && mysqli_num_rows($results) > 0) {

    // sql query to update the cart
    $updateQuery = "update cart set quantity = quantity + 1 where userID = '$userID' and productID = '$productID'";
    mysqli_query($conn, $updateQuery);
} else {

    // add query for adding to cart
    $addquery = "insert into cart (userID, productID, quantity) values ('$userID', '$productID', 1)";
    mysqli_query($conn, $addquery);
}

header("Location: ../Index.php");
exit;
?>

</body>
</html>
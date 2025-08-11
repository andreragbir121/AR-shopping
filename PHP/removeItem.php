<?php
session_start();
require_once "dbaseCon.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
session_start();
require_once "dbaseCon.php";

if (!isset($_SESSION['userID']) || !isset($_GET['productID'])) {
    echo "Missing user or product info.";
    exit;
}

$userID = $_SESSION['userID'];
$productID = $_GET['productID'];

$deleteQuery = "delete from cart where userID = '$userID' AND productID = '$productID'";
mysqli_query($conn, $deleteQuery);

header("Location: checkout.php?removed=1");
exit;
?>

</body>
</html>
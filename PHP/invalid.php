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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
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

    <h1 class="invalid">CURRENTLY UNDER CONSTRUCTION</h1>
</body>
</html>
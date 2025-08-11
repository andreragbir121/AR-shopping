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
    <title>reg</title>
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

<?php
$name = $price = $image = $category = $description = $stock = "";
$nameErr = $priceErr = $imageErr = $categoryErr = $descriptionErr = $stockErr = "";

$valid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["submit"])) {

    if (empty($_POST["name"])) {
        $name = "Product name is required";
        $valid = false;
    } else {
        $name = test_input($_POST["name"]);
        if (!preg_match("/[a-zA-Z]+[ a-zA-Z]*/", $name)) {
            $nameErr = "Name may only contain letters or ' ! and -";
            $valid = false;
        }
    }

    if (empty($_POST["price"])) {
        $priceErr = "product price is required";
        $valid = false;
    } else {
        $price = test_input($_POST["price"]);
        if (!preg_match("/^\d+(\.\d{1,2})?$/", $price)) {
            $priceErr = "Price must be a valid number";
            $valid = false;
        }
    }

    if (empty($_POST["image"])) {
        $imageErr = "image link is required";
        $valid = false;
    } else {
        $image = test_input($_POST["image"]);
    }

    if (empty($_POST["category"])) {
        $categoryErr = "category is required";
        $valid = false;
    } else {
        $category = test_input($_POST["category"]);
    }


  if (empty($_POST["description"])) {
        $descriptionErr = "description is required";
        $valid = false;
    } else {
        $description = test_input($_POST["description"]);
    }

      if (empty($_POST["stock"])) {
        $stockErr = "stocks is required";
        $valid = false;
    } else {
        $stock = test_input($_POST["stock"]);
        if (!preg_match('/^\d+$/', $stock)) {
            $stockErr = "stocks must be a valid number";
            $valid = false;
        }
    }

    if ($valid) {
        $qry = "insert into products (name, price, image, category, description, stock) values ('$name', '$price', '$image', '$category', '$description', '$stock')";
        $result = null;

        try {
            $result = mysqli_query($conn, $qry);
        } catch (Exception $e) {
            echo '<br><br>Error occurred: ' . mysqli_error($conn) . '<br><br>';
            echo " Failed to register. Please try again";
        }

        if ($result) echo "<br><br>Thank You for registering. <a href='../index.php'>Return to home</a> to continue<br><br>";
    }
}
function test_input($data) {
    $data = trim($data);          
    $data = stripslashes($data);   
    $data = htmlspecialchars($data); 
    return $data;
}
?>
<div class="reg-form">
    <h2 class="form-heading">Upload your product</h2>
    <h4 class="reg-instruction">all it takes is one form</h4>
    <img class="reg-logo" src="../Pictures/logo.png" alt="">

    <form class="account-info" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" onsubmit="return validate()">
        <input class="account-input" id="name" name="name" type="text" placeholder="Product Name" value="<?php echo $name; ?>"/><br>
        <span id="nameErr" class="error"><?php echo $nameErr; ?></span>

        <input class="account-input" id="price" name="price" type="text" placeholder="price" value="<?php echo $price; ?>"/><br>
        <span id="priceErr" class="error"><?php echo $priceErr; ?></span>
        
        <input class="account-input" id="image" name="image" type="text" placeholder="price" value="<?php echo $price; ?>"/><br>
        <span id="imageErr" class="error"><?php echo $imageErr; ?></span>


        <input class="account-input" id="category" name="category" type="text" placeholder="category"/><br>
        <span id="stockErr" class="error"><?php echo $stockErr; ?></span>

        <input class="account-input" id="description" name="description" type="text" placeholder="description"/><br>
        <span id="descriptionErr" class="error"><?php echo $descriptionErr; ?></span>

        <input class="account-input" id="stock" name="stock" type="int" placeholder="stocks"/><br>
        <span id="stockErr" class="error"><?php echo $stockErr; ?></span>


        <input type="submit" name="submit" class="submit-btn">

    </form>
</div>
</body>
</html>


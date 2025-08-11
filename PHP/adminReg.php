
<?php
// starts the session
session_start();

// calls the script for establishing database connection
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
    <!-- navigation bar -->
    <nav class="navbar">
    <ul class="Navigation">
       <li><img class ="navbar-logo" src ="../pictures/logo.png" alt=""></li> 
        <li class="nav-option" ><a class ="nav-links" href="../Index.php">Home</a></li>
        <li class="nav-option"><a class ="nav-links" href="invalid.php">About</a></li>
        <li class="nav-option"><a class ="nav-links" href="invalid.php">Contact</a></li>
        <li class="nav-option"><a class ="nav-links" href="checkout.php">checkout</a></li>

        </ul>
        <!-- shows the logout/ login-reg based on whether user is registered or logged in -->
                <?php if (isset($_SESSION['username'])) { 
                    echo '<a class="signup-btn" href="?logout=1">Logout</a>'; 
                } else { 
                    echo "<a class='signup-btn' href='login.php'>Login</a>
            <a class='signup-btn' href='Register.php'>Sign-Up</a>";
                } ?>
</nav>

<?php
$fullName = $username = $companyEmail = $password = $passwordConfirm = "";
$fullNameErr = $usernameErr = $companyEmailErr = $passwordErr = $passwordConfirmErr = "";

$valid = true;

// data validation
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["submit"])) {

    if (empty($_POST["fullName"])) {
        $fullNameErr = "Full name is required";
        $valid = false;
    } else {
        $fullName = test_input($_POST["fullName"]);
        if (!preg_match("/[a-zA-Z]+[ a-zA-Z]*/", $fullName)) {
            $fullNameErr = "Name may only contain letters or ' ! and -";
            $valid = false;
        }
    }

    if (empty($_POST["username"])) {
        $usernameErr = "A username is required";
        $valid = false;
    } else {
        $username = test_input($_POST["username"]);
        if (!preg_match("/^[a-zA-Z0-9_\-!@#$%^&*()+=.,;:]+$/", $username)) {
            $usernameErr = "username may only contain letters, numbers and special characters. No spaces";
            $valid = false;
        }
    }

    if (empty($_POST["companyEmail"])) {
        $companyEmailErr = "company Email is required";
        $valid = false;
    } else {
        $email = test_input($_POST["email"]);
        if (!preg_match("/^[a-zA-Z0-9]{3,24}@[a-zA-Z0-9]{2,40}\.[a-zA-Z]{2,4}$/", $companyEmail)) {
            $companyEmailErr = "email can only contain letters and special char";
            $valid = false;
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
        $valid = false;
    } else {
        $password = test_input($_POST["password"]);
    }

    if (empty($_POST["passwordConfirm"])) {
        $passwordConfirmErr = "Please confirm your password";
        $valid = false;
    } else {
        $passwordConfirm = test_input($_POST["passwordConfirm"]);
        if ($password !== $passwordConfirm) {
            $passwordConfirmErr = "Passwords do not match";
            $valid = false;
        }
    }

    if ($valid) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $qry = "insert into admin (fullName, username, companyEmail, password) values ('$fullName', '$username', '$companyEmail', '$password')";
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

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!-- html form -->
<div class="reg-form">
    <h2 class="form-heading">Sign Up</h2>
    <h4 class="reg-instruction">It's as easy as pie</h4>
    <img class="reg-logo" src="../Pictures/logo.png" alt="">

    <form class="account-info" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" onsubmit="return validate()">
        <input class="account-input" id="fullName" name="fullName" type="text" placeholder="Full Name" value="<?php echo $fullName; ?>"/><br>
        <span id="fullNameErr" class="error"><?php echo $fullNameErr; ?></span>

        <input class="account-input" id="username" name="username" type="text" placeholder="username" value="<?php echo $username; ?>"/><br>
        <span id="usernameErr" class="error"><?php echo $usernameErr; ?></span>

        <input class="account-input" id="companyEmail" name="companyEmail" type="companyEmail" placeholder="company Email" value="<?php echo $companyEmail; ?>"/><br>
        <span id="emailErr" class="error"><?php echo $companyEmailErr; ?></span>

        <input class="account-input" id="password" name="password" type="password" placeholder="password"/><br>
        <span id="passwordErr" class="error"><?php echo $passwordErr; ?></span>

        <input class="account-input" id="passwordConfirm" name="passwordConfirm" type="password" placeholder="Confirm Password"/><br>
        <span id="passwordConfirmErr" class="error"><?php echo $passwordConfirmErr; ?></span>

        <p class="terms-and-conditions">By registering I agree that I have read the <a href="../DOCS/terms-and-conditions-template.pdf">terms and condition</a></p>

        <input type="submit" name="submit" class="submit-btn">

        <p class="existing-account">Already have an account? <br> <a href="login.php">Login here</a></p>
    </form>
</div>

</body>
</html>

<?php
session_start();
require_once "dbaseCon.php";
$message = "";
$loggedIn = isset($_SESSION['username']);

if ($loggedIn) {
$message = "<div>Welcome back, {$_SESSION['fullName']}</div>
<p><a href='../index.php'>Continue Shopping</a></p>";

    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Login</title>
</head>
<body>
<?php
$username = $password = "";
$usernameErr = $passwordErr = "";
$userType = 'users';
$valid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"]) && !$loggedIn) {

    if (isset($_POST['userType'])) {
        $userType = ($_POST['userType'] == 'admin') ? 'admin' : 'users';
    }

    if (empty($_POST["username"])) {
        $usernameErr = "username is required";
        $valid = false;
    } else {
        $username = test_input($_POST["username"]);
        if (!preg_match("/^[a-zA-Z0-9_\-!@#$%^&*()+=.,;:]+$/", $username)) {
            $usernameErr = "username may only contain letters, numbers and special characters. No spaces";
            $valid = false;
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "password is required";
        $valid = false;
    } else {
        $password = test_input($_POST["password"]);
    }

    if ($valid) {
        $query = "select * from $userType where username = '$username'";
        try {
            $result = mysqli_query($conn, $query);
        } catch (Exception $e) {
            echo "There was an error with your login. Please try again";
        }

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $_SESSION['userType'] = $userType;
                $_SESSION['username'] = $row['username'];
                $_SESSION['fullName'] = $row['fullName'];
                $_SESSION['userID'] = $row['userID'];
                if ($userType == 'users') {
                    $_SESSION['email'] = $row['email'];
                } else {
                    $_SESSION['comapanyEmail'] = $row['comapanyEmail'];
                }
                header("Location: login.php");
                exit();
            } else {
                echo "Invalid Credentials. Please try again";
            }
        } else {
            echo "Invalid Credentials. Please Try again";
        }
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

<div class="login-form">
    <h2 class="form-heading"><?php echo $loggedIn ? "Welcome" : "Login"; ?></h2>
    <img class="reg-logo" src="../Pictures/logo.png" alt="">
    <h4 class="reg-instruction"><?php echo $loggedIn ? "You're logged in" : "Login to your account"; ?></h4>
    <?php echo $message; ?>

    <?php if (!$loggedIn): ?>
    <form class="login-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validate()">
        <div class="userType">
            User <input type="radio" name="userType" value="users" <?php echo ($userType == 'users') ? 'checked' : ''; ?>>
            Admin <input type="radio" name="userType" value="admin" <?php echo ($userType == 'admin') ? 'checked' : ''; ?>>
        </div>

        <div class="credentials">
            <input class="login-info" id="username" name="username" type="text" placeholder="username" value="<?php echo $username; ?>"/><br>
            <span id="usernameErr" class="error"><?php echo $usernameErr; ?></span>

            <input class="login-info" id="password" name="password" type="password" placeholder="password" value="<?php echo $password; ?>"/><br>
            <span id="passwordErr" class="error"><?php echo $passwordErr; ?></span>
        </div>

        <div class="remember-me">
            <input class="rem-checkbox" type="checkbox" id="remember-me">
            <label class="rem-text" for="remember-me">Remember me</label>
        </div>

        <input type="submit" class="submit-btn" id="submit" name="submit" value="Login"/>
        <a class="forgot-psw" href="">Forgot your password?</a>
        <p class="register">Don't have an account yet?<a href="register.php" class="register-link"> Register</a></p>
    </form>
    <?php else: ?>
    <form method="post">
        <input type="submit" name="logout" class="submit-btn" value="Logout"/>
    </form>
    <?php endif; ?>
</div>

</body>
</html>

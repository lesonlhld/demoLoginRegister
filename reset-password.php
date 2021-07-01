<?php
require_once("connect.php");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Forget Password</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="mystyle.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <?php
    // define variables and set to empty values
    $passwordErr = $cpasswordErr = "";
    $password = $cpassword = "";

    if (isset($_GET["email"])) {
        $email = $_GET["email"];
    } elseif (isset($_POST["email"])) {
        $email = $_POST["email"];
    } else {
        echo "<script type='text/javascript'>alert('Invalid Email');</script>";
    }

    if (isset($_GET["reset_token"])) {
        $reset_token = $_GET["reset_token"];
    } elseif (isset($_POST["reset_token"])) {
        $reset_token = $_POST["reset_token"];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["password"])) {
            $passwordErr = "Password is required";
        } else {
            $password = $_POST["password"];
            if (strlen($password) < 6) {
                $passwordErr = "Passwords must be at least 6 characters!";
            }
        }

        if (empty($_POST["cpassword"])) {
            $cpasswordErr = "Confirm password is required";
        } else {
            $cpassword = $_POST["cpassword"];
            if (strlen($cpassword) < 6) {
                $cpasswordErr = "Confirm passwords must be at least 6 characters!";
            } elseif ($passwordErr == "" && $password != $cpassword) {
                $cpasswordErr = "Password does match";
            }
        }


        if ($passwordErr == "" && $cpasswordErr == "") {
            $email = $_POST["email"];
            $reset_token = $_POST["reset_token"];

            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_object($result);
                if ($user->reset_token == $reset_token) {
                    $sql = "UPDATE users SET password='$password', reset_token=null WHERE email='$email' AND reset_token='$reset_token'";
                    mysqli_query($conn, $sql);

                    echo "<script type='text/javascript'>alert('Password has been changed');
                            window.location.href='login.php';</script>";
                } else {
                    echo "<script type='text/javascript'>alert('Recovery email has been expired');</script>";
                }
            } else {
                echo "<script type='text/javascript'>alert('Invalid Email');</script>";
            }
        }
    }
    ?>

    <div class="wrapper fadeInDown">
        <div id="formContent">
            <br>
            <form action="reset-password.php" method="POST">
                <h2>Set Password</h2>
                <input type="hidden" name="email" value="<?php echo $email; ?>">
                <input type="hidden" name="reset_token" value="<?php echo $reset_token; ?>">
                <input type="password" placeholder="New Password" class="fadeIn second" name="password">
                <br>
                <span class="error"><?php echo $passwordErr; ?></span>
                <br><br>
                <input type="password" placeholder="Confirm Password" class="fadeIn third" name="cpassword">
                <br>
                <span class="error"><?php echo $cpasswordErr; ?></span>
                <br><br>
                <input type="submit" class="fadeIn fourth" value="Submit">
            </form>

            <div id="formFooter">
                <p>Have account? <a href="login.php">Login</a></p>
            </div>

        </div>
    </div>
</body>

</html>
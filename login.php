<!DOCTYPE HTML>
<?php
session_start();
require_once("connect.php");
?>

<html>

<head>
    <title>Login</title>
    <meta charset="UFT-8">
    <link rel="stylesheet" href="mystyle.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <?php
    // define variables and set to empty values
    $emailErr = $passwordErr = "";
    $email = $password = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }

        if (empty($_POST["password"])) {
            $passwordErr = "Password is required";
        } else {
            $password = $_POST["password"];
        }

        if ($emailErr == "" && $passwordErr == "") {
            $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password' ";
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);
            if ($num_rows == 0) {
                echo "<script type='text/javascript'>alert('Incorrect email or password!');</script>";
            } else {
                $_SESSION['email'] = $email;
                // $_SESSION['email'] = $result["email"];
                // $_SESSION['name'] = $result["name"];
                // $_SESSION['email'] = $result["email"];
                // $_SESSION['gender'] = $result["gender"];
                header('Location: index.php');
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

    <div class="wrapper fadeInDown">
        <div id="formContent">
            <br>
            <form action="login.php" method="POST">
                <h2>Login</h2>
                <input type="text" placeholder="Email" class="fadeIn second" name="email">
                <br>
                <span class="error"><?php echo $emailErr; ?></span>
                <br><br>
                <input type="password" placeholder="Password" class="fadeIn third" name="password">
                <br>
                <span class="error"><?php echo $passwordErr; ?></span>
                <br><br>
                <input type="submit" class="fadeIn fourth" value="Login">
            </form>

            <div id="formFooter">
                <p>Forget Password? <a class="underlineHover" href="forget-password.php">Reset</a></p>
            </div>
            <div id="formFooter">
                <p>No account? <a class="underlineHover" href="register.php">Register</a></p>
            </div>

        </div>
    </div>
</body>

</html>
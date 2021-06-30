<!DOCTYPE HTML>  
<?php
    session_start();
    require_once("connect.php");
?>

<html>
    <head>
        <title>Login</title>
        <meta charset="UFT-8">
        <link rel="stylesheet" href="mystyle.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>

    <body>
        <?php
            // define variables and set to empty values
            $usernameErr = $passwordErr = "";
            $username = $password = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST["username"])) {
                    $usernameErr = "Username is required";
                } else {
                    $username = test_input($_POST["username"]);
                    // check if name only contains letters and number
                    if (!preg_match("/^[a-zA-Z-0-9.]*$/",$username)) {
                    $usernameErr = "Only letters, numbers and dots allowed";
                    }
                }

                if (empty($_POST["password"])) {
                    $passwordErr = "Password is required";
                } else {
                    $password = test_input($_POST["password"]);
                }

                if ($usernameErr == "" && $passwordErr == ""){
                    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password' ";
                    $result = mysqli_query($conn, $sql);
                    $num_rows = mysqli_num_rows($result);
                    if ($num_rows == 0) {
                        echo "<script type='text/javascript'>alert('Incorrect username or password!');</script>";
                    }else{
                        $_SESSION['username'] = $username;
                        // $_SESSION['username'] = $result["username"];
                        // $_SESSION['name'] = $result["name"];
                        // $_SESSION['email'] = $result["email"];
                        // $_SESSION['gender'] = $result["gender"];
                        header('Location: index.php');
                    }
                }
            }
            
            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
        ?>
        
        <div class="wrapper fadeInDown">
            <div id="formContent">
                <br>
                <form action="login.php" method="POST" >
                    <h2>Login</h2>
                    <input type="text" placeholder="Username" class="fadeIn second" name="username">
                    <br>
                    <span class="error"><?php echo $usernameErr;?></span>
                    <br><br>
                    <input type="password" placeholder="Password" class="fadeIn third" name="password">
                    <br>
                    <span class="error"><?php echo $passwordErr;?></span>
                    <br><br>
                    <input type="submit" class="fadeIn fourth" value="Login">
                </form>
                
                <div id="formFooter">
                <p>No account? <a class="underlineHover" href="register.php">Register</a></p>
                </div>

            </div>
        </div>
    </body>
</html>
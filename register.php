<!DOCTYPE HTML>  
<?php
    require_once("connect.php");
?>

<html>
    <head>
        <title>Register</title>
        <meta charset="UFT-8">
        <link rel="stylesheet" href="mystyle.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>

    <body>
        <?php
            // define variables and set to empty values
            $usernameErr = $passwordErr = $nameErr = $emailErr = $genderErr = "";
            $username = $password = $name = $email = $gender = "";

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
                    if(strlen($password) < 6){
                        $passwordErr = "Passwords must be at least 6 characters!";
                    }
                }

                if (empty($_POST["name"])) {
                    $nameErr = "Name is required";
                } else {
                    $name = test_input($_POST["name"]);
                }

                if (empty($_POST["email"])) {
                    $emailErr = "Email is required";
                } else {
                    $email = test_input($_POST["email"]);
                    // check if e-mail address is well-formed
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format";
                    }
                }

                if (empty($_POST["gender"])) {
                    $genderErr = "Gender is required";
                } else {
                    $gender = test_input($_POST["gender"]);
                }
                
                if ($usernameErr == "" && $passwordErr == "" && $nameErr == "" && $emailErr == "" && $genderErr == ""){
                    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password' ";
                    $result = mysqli_query($conn, $sql);
                    $num_rows = mysqli_num_rows($result);
                    if ($num_rows > 0) {
                        echo "Username exist!";
                    }else{
                        $sql = "INSERT INTO users (name, username, password, email, gender) VALUES ('$name', '$username', '$password', '$email', '$gender')";

                        if ($conn->query($sql) === TRUE) {
                            header('Location: login.php');
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
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
                <form action="register.php" method="POST">
                    <h2>Register</h2>
                    <input type="text" placeholder="Username" name="username" value="<?php echo $username;?>">
                    <br>
                    <span class="error"><?php echo $usernameErr;?></span>
                    <br><br>
                    <input type="password" placeholder="Password" name="password" value="<?php echo $password;?>">
                    <br>
                    <span class="error"><?php echo $passwordErr;?></span>
                    <br><br>
                    <input type="text" placeholder="Name" name="name" value="<?php echo $name;?>">
                    <br>
                    <span class="error"><?php echo $nameErr;?></span>
                    <br><br>
                    <input type="text" placeholder="Email" name="email" value="<?php echo $email;?>">
                    <br>
                    <span class="error"><?php echo $emailErr;?></span>
                    <br><br>
                    <input type="radio" name="gender"
                    <?php if (isset($gender) && $gender=="male") echo "checked";?>
                    value="male">Male
                    <input type="radio" name="gender"
                    <?php if (isset($gender) && $gender=="female") echo "checked";?>
                    value="female">Female
                    <br>
                    <span class="error"><?php echo $genderErr;?></span>
                    <br><br>
                    <input type="submit" class="fadeIn fourth" value="Register">

                </form>

        
                <div id="formFooter">
                <p>Have account? <a href="login.php">Login</a></p>
                </div>

            </div>
        </div>
    </body>
</html>
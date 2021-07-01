<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
require_once("connect.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Forget Password</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="mystyle.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php
            // define variables and set to empty values
            $emailErr = "";
            $email = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"])) {
                if (empty($_POST["email"])) {
                    $emailErr = "Email is required";
                } else {
                    $email = test_input($_POST["email"]);
                    // check if e-mail address is well-formed
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $emailErr = "Invalid email format";
                    }
                }

                if ($emailErr == ""){
                    $sql = "SELECT * FROM users WHERE email = '$email'";
                    $result = mysqli_query($conn, $sql);
                    $num_rows = mysqli_num_rows($result);
                    if ($num_rows == 0) {
                        echo "<script type='text/javascript'>alert('Incorrect email!');</script>";
                    }else{
                        $reset_token = time().md5($email);
                        $sql = "UPDATE users SET reset_token='$reset_token' WHERE email='$email'";
                        mysqli_query($conn, $sql);
                        $message = "<p>Please click the link below to reset your password</p>";
                        $message .= "<a href='http://localhost/demothuctap/reset-password.php?email=$email&reset_token=$reset_token'>";
                        $message .= "Reset password";
                        $message .= "</a>";
                        send_mail($email, "Reset password", $message);
                    }
                }
            }
            
            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
                        
            function send_mail($to, $subject, $message) {
                $mail = new PHPMailer();
            
                try {
                    //Server settings
                    
                    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
                    $mail->isSMTP();                                            // Set mailer to use SMTP
                    $mail->Host       = 'smtp.gmail.com;';  // Specify main and backup SMTP servers
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'leson0310@gmail.com';                     // SMTP username
                    $mail->Password   = 'leson1606';                               // SMTP password
                    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
                    $mail->Port       = 587;                                    // TCP port to connect to
                
                    $mail->setFrom('leson0310@gmail.com');
                    //Recipients
                    $mail->addAddress($to);
                
                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = $subject;
                    $mail->Body    = $message;
                
                    if($mail->Send())
                    {
                        echo "<script type='text/javascript'>alert('Check Your Email and Click on the link sent to your email');
                        window.location.href='login.php';</script>";
                    }
                    else
                    {
                        echo "<script type='text/javascript'>alert('Cannot send reset mail. Mailer Error: {$mail->ErrorInfo}');</script>";
                    }
                } catch (Exception $e) {
                    echo "<script type='text/javascript'>alert('Cannot send reset mail. Mailer Error: {$mail->ErrorInfo}');</script>";
                }
            }
        ?>
        
        <div class="wrapper fadeInDown">
            <div id="formContent">
                <br>
                <form action="forget-password.php" method="POST" >
                    <h2>Reset Password</h2>
                    <input type="text" placeholder="Email" class="fadeIn second" name="email">
                    <br>
                    <span class="error"><?php echo $emailErr;?></span>
                    <br><br>
                    <input type="submit" class="fadeIn third" value="Reset">
                </form>
                
                <div id="formFooter">
                <p><a class="underlineHover" href="login.php">Go Back</a></p>
                </div>

            </div>
        </div>
    </body>
</html>
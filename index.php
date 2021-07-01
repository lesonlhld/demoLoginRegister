<?php
session_start();
require_once("connect.php");
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
}
?>

<html>

<head>
    <title>Welcome</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="mystyle.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <?php
    $email = $_SESSION['email'];
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_object($result);
    }
    ?>
    <h2>Welcome <?php echo $user->name;  ?>!</h2>
    <a href="logout.php">Logout</a>
</body>

</html>
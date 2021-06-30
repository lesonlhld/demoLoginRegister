<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
    }
?>

<html>
    <head>
        <title>Welcome</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="mystyle.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>

    <body>
        <h2>Welcome <?php echo $_SESSION['username'];  ?>!</h2>
    </body>
</html>
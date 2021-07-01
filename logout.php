<?php
    session_start();
    if (isset($_SESSION['email'])) {
        session_start();
        session_destroy();
        header('Location: login.php');
        die;
    }
?>
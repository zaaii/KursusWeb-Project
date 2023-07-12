<?php
    session_start();
    require("model.php");
    
    // Destroy the session and unset the session variables
    session_destroy();
    unset($_SESSION['id_user']);
    
    // Redirect to the login page or any other desired page
    header("Location: login.php");
    exit;
    ?>
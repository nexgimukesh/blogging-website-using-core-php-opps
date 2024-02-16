<?php
session_start();
    // TODO: need to implement logout functionality and redirect it to login page
    //session_destroy(); //this function is not used for essential website because it removes everything from the session.
    unset($_SESSION['authUser']);
    header("location: login.php");
?>
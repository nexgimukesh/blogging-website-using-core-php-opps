<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//if we start session in header.php file then this will reflact on every page and we don't need to write in every page.
include_once '../../core/constants.php';
include_once '../../core/helper.php';

if(isLogin()){
?>
    <a href="/modules/dashboard">
    Home
    </a>   
    <a href="/modules/posts">
    Posts
    </a>

    <a href="/modules/users">
        Users
    </a>

    <a href="/modules/auth/logout.php">
        Logout
    </a>
<?php } ?>
    <!-- <a href="/modules/auth/register.php">Create a New User</a>
    <a href="/modules/auth/forgot-password.php">Forgot Password?</a> -->
<?php

if(isLogin2()){
?> 
    <a href="/modules/auth/logout.php">
        Logout
    </a>
<?php
}

if(sessionNotSet()){
?>
        <a href="/modules/auth/register.php">Create a New User</a>
        <a href="/modules/auth/forgot-password.php">Forgot Password?</a>
<?php
}elseif (sessionNotSet() && $_SERVER['REQUEST_URI'] === '/modules/auth/forgot-password-thankyou.php'){
    ?>
     <a href="/modules/auth/forgot-password.php">Forgot Password?</a>
    <?php
}
?>



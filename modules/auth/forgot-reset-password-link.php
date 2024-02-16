<?php
    include '../common/header.php';
    $skip_session_start = true;
    include_once '../auth/registrationProcess.php';
    if(isLogin()){
        header('location: /modules/dashboard');
    }
    // pr($_REQUEST);
    $email=base64_decode($_REQUEST['email']);
    $forgotKey=$_REQUEST['forgotKey'];
    //fetch the current user
    $userObject = new RegistrationProcess();
    $user=$userObject->getUserByEmail($email);
    // pr($user);
    

    //if someone has touched those encrypted values
    $user=$userObject->getUserByEmail($email);
    if(empty($user)){
        die("<br> <br>This link has expired. Please use the forgot password feature to reset your password. <a href='forgot-password.php'>Forgot Password</a>");
    }

    if($user['forgot_key']!=$forgotKey){
        die("<br> <br>This link has expired. Please use the forgot password feature to reset your password. <a href='forgot-password.php'>Forgot Password</a>");
    }
    // pr($user);
    // die();

    //if user is here a valid user then 

?>
    <h1>Enter a new password to update</h1>
    <form action="authProcessor.php" method="post">
        <input type="password" name="password" placeholder="enter a new password to update.">
        <input name="_action" value="update_user_password_with_forgot_key" type="hidden">
        <input name="forgot_key" value=<?php echo $forgotKey ?> type="hidden">
        <input name="email" value=<?php echo $_REQUEST['email'] ?> type="hidden">
        <button type="submit" name="update-password">Update Password</button>
    </form>
    <div class="error">
    <?php 
        if(!empty($_GET) && isset($_GET['err'])){
            echo $_GET['err'];
        }
        ?>
   </div>
   <a href="/modules/auth/login.php">
        Login
</a>
<br>
<br>
</form>
<?php
    include '../common/footer.php';
?>
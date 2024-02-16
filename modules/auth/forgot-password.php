<?php
    include '../common/header.php';
    if(isLogin()){
        header('location: /modules/dashboard');
    }
?>
    <h1>Forgot Password Page</h1>
    <form action="authProcessor.php" method="post">
        <input type="text" name="email" placeholder="email">
        <input name="_action" value="send_reset_password_link" type="hidden">
        <button type="submit" name="forgot">Send Reset Link</button>
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
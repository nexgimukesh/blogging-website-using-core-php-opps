<?php
    include '../common/header.php';
   
    if(isLogin()){
        header('location: /modules/dashboard');
    }
?>
   <div class="error">
    <?php 
        if(!empty($_GET) && isset($_GET['err'])){
            echo $_GET['err'];
        }

        if(!empty($_GET) && isset($_GET['email'])){
            $actualEmail=base64_decode($_GET['email']);
            ?>
                <form action="authProcessor.php" method="post">
                <input type="hidden" name="email" value="<?php echo $actualEmail ?>" placeholder="email">
                <input name="_action" value="send_reset_password_link" type="hidden">
                <button type="submit" name="forgot">Resend Link</button>
                </form>
            <?php
        }
        ?>
   </div>
<?php
    include '../common/footer.php';
?>
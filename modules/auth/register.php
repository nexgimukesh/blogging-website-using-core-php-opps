<?php 
include '../common/header.php';
if(isLogin()){
    header('location:/modules/dashboard');
}
?>
<h1>User Registration</h1>
<form action="authProcessor.php" method="post">
    <input type="text" name="full_name" placeholder="Full name">
    <input type="text" name="email" placeholder="email">
    <input type="password" name="password" placeholder="password">
    <input name="_action" value="process_register" type="hidden">
    <button type="submit" name="register">Register</button>
   <div class="error">
    <?php 
        if(!empty($_GET) && isset($_GET['err'])){
            echo $_GET['err'];
        }
        ?>
   </div>
   <div class="succ-message">
        <?php 
          if(!empty($_GET) && isset($_GET['msg'])){
            echo $_GET['msg'];
          }  
        ?>
   </div>
</form>
<a href="login.php">Already have account, click here to login</a>
<?php

include '../common/footer.php';
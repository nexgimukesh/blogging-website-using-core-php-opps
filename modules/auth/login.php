<?php
    include '../common/header.php';
    include "../auth/loginProcess.php";
    // TODO: need to implement login form
    // echo "<pre>";
    // print_r($_POST);
    // print_r($_SESSION);
    // echo "</pre>";
    if(!isset($_SESSION['authUser'])){
?>
    <h1>Login Page</h1>
    <form action="authProcessor.php" method="post">
        <input type="text" name="email" placeholder="email">
        <input type="password" name="password" placeholder="password">
        <input name="_action" value="process_login" type="hidden">
        <button type="submit" name="login">Login</button>
    </form>
    <div class="error">
    <?php 
        if(!empty($_GET) && isset($_GET['err'])){
            echo $_GET['err'];
        }
        ?>
   </div>
</form>
<?php
    include '../common/footer.php';
}else{
    echo "<br> <br> You can't access login page without logout";
}
?>
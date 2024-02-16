<?php
    include_once '../common/header.php';
    include_once "../../core/helper.php";
    $skip_session_start = true;
    include_once "../auth/registrationProcess.php";
    if(!isset($_SESSION['authUser'])){
        header('location: /modules/auth/login.php');
    }
    
    $robj=new RegistrationProcess();
    $user_data=$robj->getUserDetails();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Step 2</title>
</head>
<body>
    <form action="/modules/auth/authProcessor.php" method="post" style="width: 600px;">
    <h3>Step 2: Identify Verification</h3>
    
    <!-- <input id="age" name="age" type="hidden" value=""> -->
    
    <input id="fieldset" name="fieldset" type="hidden" value="2">
        <label for="addhar">Addhar No:</label>
        <input type="text" id="addhar" name="addhar" value="<?php
            if(isset($user_data[0]['addhar'])){
                echo  $user_data[0]['addhar']; 
            }else{
                echo "";
            }
                 ?>"
        required>
        <br>
        <?php 
        $a = new RegistrationProcess();
        $age=$a->getUserAge();
        if($age>18){
                ?>
        <label for="pan">Pan Card No:</label>
        <input type="text" id="pan" name="pan" value="<?php
            if(isset($user_data[0]['pan'])){
                echo  $user_data[0]['pan']; 
            }else{
                echo "";
            }
                 ?>" required>
        <br>
        <?php
            }
        ?>
        <input name="_action" value="idverify_register" type="hidden">
        
        <a href="/modules/registration/basicDetails.php">
        Previous
        </a>
        <!-- <?php
            // if(isset($user_data[0]['addhar'])){
        ?>
        <br>
        <a href="/modules/registration/marks.php">
        Next
        </a>
        <?php
            // }
        ?> -->
        <br>
        <br>
        <button type="submit" name="idverify">Next</button>
        <br>
        <br>
        <div class="error">
            <?php 
                if(!empty($_GET) && isset($_GET['err'])){
                    echo $_GET['err'];
                }
                ?>
        </div>
    </form>
</body>

</html>
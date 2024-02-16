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
    <title>Registration - Step 3</title>
</head>
<body>
    <form action="/modules/auth/authProcessor.php" method="post" style="width: 600px;">
    <h3>Step 3: Marks Details</h3>
    <!-- <input id="uid" name="uid" type="hidden" value=""> -->
    <input id="fieldset" name="fieldset" type="hidden" value="3">
        <label for="ten">10th Marks %:</label>
        <input type="text" id="ten" name="ten" value="<?php
            if(isset($user_data[0]['ten'])){
                echo  $user_data[0]['ten']; 
            }else{
                echo "";
            }
                 ?>" required>
        <br>
        <label for="twelve">12th Marks %:</label>
        <input type="text" id="twelve" name="twelve" value="<?php
            if(isset($user_data[0]['twelve'])){
                echo  $user_data[0]['twelve']; 
            }else{
                echo "";
            }
                 ?>" required>
        <br>
        <label for="graduation">Graduation Marks %:</label>
        <input type="text" id="graduation" name="graduation" value="<?php
            if(isset($user_data[0]['graduation'])){
                echo  $user_data[0]['graduation']; 
            }else{
                echo "";
            }
                 ?>"  required>
        <br>
        <input name="_action" value="marks_register" type="hidden">
        <?php
            if(isset($user_data[0]['nationality'])){
                $nation=$user_data[0]['nationality'];
                if($nation=="India"){
        ?>
        <a href="/modules/registration/idVerify.php">
        Previous
        </a>
        <?php
                }
                else{
                    ?>
                        <a href="/modules/registration/basicDetails.php">
                        Previous
                        </a>

                    <?php
                }
            }
        ?>
        <br>
        <br>
        <button type="submit" name="marks" value="sub">Submit</button>
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
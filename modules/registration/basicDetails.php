<?php
    include_once '../common/header.php';
    include_once "../../core/helper.php";
    $skip_session_start = true;
    include_once "../auth/registrationProcess.php";
    if(!isset($_SESSION['authUser'])){
        header('location: /modules/auth/login.php');
        exit;
    }
    
    $robj=new RegistrationProcess();
    $user_data=$robj->getUserDetails();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Step 1</title>
</head>
<body>

    <form action="/modules/auth/authProcessor.php" method="post" style="width: 600px;">
        <h3>Step 1: Basic Details</h3>

        <!-- <input id="uid" name="uid" type="hidden" value=""> -->
        <input id="fieldset" name="fieldset" type="hidden" value="1">

        <label for="mother_name">Mother Name:</label>
        <input type="text" id="mother_name" name="mother_name"  value="<?php
            if(isset($user_data[0]['id'])){
                echo  $user_data[0]['mother_name']; 
            }else{
                echo "";
            }
                 ?>" required>
        <br>

        <label for="father_name">Father Name:</label>
        <input type="text" id="father_name" name="father_name" value="<?php 
             if(isset($user_data[0]['id'])){
                echo  $user_data[0]['father_name']; 
            }else{
                echo "";
            }
        ?>" required>
        <br>
            
        <label for="dob">Date of Birth</label>
        <input type="date" id="dob" name="dob" value="<?php
             if(isset($user_data[0]['id'])){
                echo  $user_data[0]['dob']; 
            }else{
                echo "";
            }
        ?>" required>
        <br>


        <label for="nationality">Nationality:</label>
        <select id="nationality" name="nationality" required>
                    <?php
                    $arr_nation=['United States','United Kingdom','Canada','India'];
                    //$user_nationality = isset($user_data[0]['nationality']) ? $user_data[0]['nationality'] : '';
                    $user_nationality = '';
                    if (isset($user_data[0]['nationality'])) {
                        $user_nationality = $user_data[0]['nationality'];
                    }


                    if (isset($user_data[0]['id']) && isset($user_data[0]['nationality']) && in_array($user_nationality, $arr_nation)) {
                        // If user data exists and nationality is valid, show all options with selected nationality
                        foreach ($arr_nation as $value) {
                            $select = ($value === $user_nationality) ? 'selected' : '';
                            ?>
                            <option <?php echo $select; ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
                            <?php
                        }
                    } else {
                        // If user data doesn't exist or nationality is invalid, show default options
                        ?>
                        <option value="" disabled selected>Select Nationality</option>
                        <?php
                        foreach ($arr_nation as $value) {
                            ?>
                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                            <?php
                        }
                    }
                    ?>
        </select>


        <br>
        <input name="_action" value="basic_register" type="hidden">
        <br>
        <button type="submit" name="basic">Next</button>
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
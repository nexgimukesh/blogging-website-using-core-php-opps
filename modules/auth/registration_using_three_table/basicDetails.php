<?php
    session_start();
    if (isset($_SESSION['authUser'])) {
        $user_id = $_SESSION['authUser'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Step 1</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
<a href="/modules/auth/logout.php">
        Logout
</a>

    <form action="authProcess.php" method="post" style="width: 600px;">
        <h3>Step 1: Basic Details</h3>

        <input id="uid" name="uid" type="hidden" value="<?php echo htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8'); ?>">

        <label for="mother_name">Mother Name:</label>
        <input type="text" id="mother_name" name="mother_name" required>

        <label for="father_name">Father Name:</label>
        <input type="text" id="father_name" name="father_name" required>

        <label for="dob">Date of Birth</label>
        <input type="date" id="dob" name="dob" required>

        <label for="nationality">Nationality:</label>
        <select id="nationality" name="nationality" required>
            <option value="" disabled selected>Select Nationality</option>
            <option value="United States">United States</option>
            <option value="United Kingdom">United Kingdom</option>
            <option value="Canada">Canada</option>
            <option value="India">India</option>
        </select>

        <input name="_action" value="basic_register" type="hidden">
        <!-- <a href="/modules/auth/idVerify.php" style="float: right;">
        Next
        </a> -->
        <br>
        <button type="submit" name="basic">Next</button>
        <br>
        <br>
        <div class="error">
        <?php 
            if(!empty($_GET) && isset($_GET['err'])){
                echo $_GET['err'];
            }
            //echo $_GET['id'];
            ?>
        </div>
    </form>
</body>
</html>
<?php
    }
?>

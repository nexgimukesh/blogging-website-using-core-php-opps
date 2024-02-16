<?php
    session_start();
    if (isset($_SESSION['authUser'])) {
        $user_id = $_SESSION['authUser'];
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Step 2</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <a href="/modules/auth/logout.php">
        Logout
    </a>
    <form action="authProcess.php" method="post" style="width: 600px;">
    <h3>Step 2: Identify Verification</h3>
    <input id="uid" name="uid" type="hidden" value="<?php echo htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8'); ?>">
        <label for="addhar">Addhar No:</label>
        <input type="text" id="addhar" name="addhar" required>
            <?php 
                // if(!empty($_GET) && isset($_GET['err'])){
                //         $hidden=$_GET['err'];
                    ?>
                    <label for="pan">Pan Card No:</label>
                    <input type="text" id="pan" name="pan" required>
                <?php
                // }
                ?>

        <input name="_action" value="idverify_register" type="hidden">
        <a href="/modules/auth/basicDetails.php">
        Previous
        </a>
        <a href="/modules/auth/marks.php" style="float: right;">
        Next
        </a>
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
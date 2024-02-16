<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Step 3</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <a href="/modules/auth/logout.php">
        Logout
    </a>
    <form action="authProcess.php" method="post" style="width: 600px;">
    <h3>Step 3: Marks Details</h3>
        <label for="ten">10th Marks %:</label>
        <input type="text" id="ten" name="ten" required>

        <label for="twelve">12th Marks %:</label>
        <input type="text" id="twelve" name="twelve" required>
        <label for="graduation">Graduation Marks %:</label>
        <input type="text" id="graduation" name="graduation" required>

        <input name="_action" value="marks_register" type="hidden">
        <a href="/modules/auth/idVerify.php">
        Previous
        </a>
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
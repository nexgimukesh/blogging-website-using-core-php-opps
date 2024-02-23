<?php
include_once '../../modules/common/header.php';
include_once '../auth/loginProcess.php';

if(isset($_SESSION['authUser'])){
?>
    <div class="dash">
        <h2>Welcome <?php echo $_SESSION['authUser']['first_name']; ?></h2>
        <h1>User Dashboard Hello</h1>
    </div>
<?php
    include_once '../../modules/common/footer.php';
} else {
    // User is not logged in, redirect to login page
    header("location: ../auth/login.php");
    exit(); // Make sure to exit after sending the header to prevent further execution
}
?>

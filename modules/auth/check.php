<?php
// session_start();
// print_r($_SESSION['authUser']);
include_once "../auth/registrationProcess.php";
$a=new RegistrationProcess();
$age=$a->getUserAge();
print_r($age);
die();
?>
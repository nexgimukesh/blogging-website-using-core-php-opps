<?php
include_once "../../core/constants.php";
include_once "../../core/helper.php";
include_once "../auth/loginProcess.php";
include_once "../../modules/auth/regProcess.php";
//include_once "../auth/basicDetails.php";

//security layer
if (empty($_POST)) {
    die("invalid access");
}
if (!isset($_POST['_action'])) {
    die("invalid _action value");
}

//pr($_POST);
$_action=$_POST['_action'];
// $dateOfBirth="";
// $currentDate="";
if($_action=="basic_register") {

    // $session=new LoginProcess();
    // $session->createSession();

    $mother_name=$_POST['mother_name'];
    $father_name=$_POST['father_name'];
    $dob=$_POST['dob'];
    $nationality=$_POST['nationality'];
    $uid=$_POST['uid'];

    
    $err="";
    if(!ctype_alpha($mother_name)){
        $err="mother name must be an alphabetic";
    }
    if(!ctype_alpha($father_name)){
        $err="father name must be an alphabetic";
    }

    $dateOfBirth = new DateTime($dob);
    $currentDate = new DateTime();
    if($dateOfBirth >= $currentDate){
        $err="Date of Birth Should not be a future Date";
    }

    if(!empty($err)){
        header("location: ../auth/basicDetails.php?err=$err");
        exit;
    }

    $authObject = new RegistrationProcess();
    $stmt = $authObject->basicDetails($_POST);

    if(isset($stmt)){
            header('Location: ../auth/idVerify.php?uid='.$uid);
    }else{
        header("location: ../auth/basicDetails.php?err=Basic details are not saved");
        exit;
    }
}elseif($_action=="idverify_register") {
    //$age=$currentDate->diff($dateOfBirth)->y;
    $addhar=$_POST['addhar'];
    $pan=$_POST['pan'];
    $uid=$_POST['uid'];
    // pr($_POST);
    // die();

    // if($age<18){
    //     $err="hidden";
    // }

    // if(!is_numeric($addhar)){
    //     $err="Addhar number must be a numeric";
    // }
    // $len=str_word_count($addhar);
    // if($len!=12){
    //     $err="Addhar number must be 12 digit";
    // }

    if(!empty($err)){
        header("location: ../auth/idVerify.php?err=$err");
       exit;
    }

    $authObject = new RegistrationProcess();
    $stmt = $authObject->idVerify($_POST);
    
    if(isset($stmt)){
        header("location: ../auth/marks.php?uid=".$uid);
        //print_r($_SESSION['authUser']);
    }else{
        header("location: ../auth/idVerify.php?err=Id Details Not saved");
        exit;
    }
}elseif($_action=="marks_register") {
    $ten=$_POST['ten'];
    $twelve=$_POST['twelve'];
    $graduation=$_POST['graduation'];
    $twelve_numeric=intval($twelve);
    $graduation_numeric=intval($graduation);

    if(!is_numeric($ten)){
        $err="10th result must be a numeric value";
    }else{
        
    }

    if(!is_numeric($twelve)){
        $err="12th result must be a numeric value";
    }

    if(!is_numeric($graduation)){
        $err="Graduation result must be a numeric value";
    }

    if(!empty($err)){
        header("location: ../auth/marks.php?err=$err");
        exit;
    }

    $authObject = new RegistrationProcess();
    $stmt = $authObject->marks($_POST);
    
    if(isset($stmt)){
        header('location: ../auth/thankyou.php');
        //print_r($_SESSION['authUser']);
    }else{
        header("location: ../auth/marks.php?err=Marks Not saved");
        exit;
    }
}
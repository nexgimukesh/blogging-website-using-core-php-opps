<?php
//session_start();
include_once "../../core/constants.php";
include_once "../../core/helper.php";
include_once "../auth/loginProcess.php";
include_once "../auth/registrationProcess.php";
//include_once "../dashboard/index.php";
/**
 * this file will process all auth functions 
 * this file only support post method
 */

// if(empty($_POST)){
//     die("invalid access");
// }
// echo "<pre>";
// print_r($_POST);
// print_r($_GET);
// print_r($_REQUEST);
// print_r($_SESSION);
// echo "</pre>";

// $_POST['userId']=12;
// $_SESSION['userId']=18;
// echo "<pre>";
// print_r($_POST);
// print_r($_SESSION);
// echo "</pre>";

//security layer
if (empty($_POST)) {
    die("invalid access");
}
if (!isset($_POST['_action'])) {
    die("invalid _action value");
}
//pr($_POST);
$_action = $_POST['_action'];
if ($_action == "process_login") {
    $authObject = new LoginProcess();
    // if user loggedIn
    // here $_POST is sending all data of the login form
    // if we use $POST['email'] //then it send only email from login form.
    // print_r($_POST);
    // exit();
    $authObject->verifyLogin($_POST);
    $user = $authObject->getCurrentUser();

    // print_r($user);
    // die();
    // echo "in authprossesor.php";
    // pr($user);

    //if invalid username and password then user data memeber will be null
    if (!$user) {
        header('location: /modules/auth/login.php?err="indalid username and password"');
        exit();
    }

    //if user is rejected by admin then it will show
    if ($user['status'] == 0) {
        header('location: /modules/auth/login.php?err="Hey ' . $user['first_name'] . ' your id is Rejected by Admin. <br>  please contact with your admin to resolve this issue."');
        exit();
    }

    $authObject->createSession();
    //if user is successfully logged In.
    if ($user['status'] == 1) {
         header('location: /modules/dashboard/index.php?err="Hey '.$user['first_name'].' you are successfully logged In"');
    }

    //if user has correct username and password but that is under review.
    $robj=new RegistrationProcess();
    $user_data=$robj->getUserDetails();

    // pr($user_data);
    // die();
    // if ($user['status'] == 2) {
    //     header('location: ../registration/basicDetails.php?id=" '.$_SESSION['authUser']['id'].'"');
    // }
        
    
    if ($user['status'] == 2 && $user_data[0]['fieldset']==1) {
        header('location: ../registration/idVerify.php');
    }elseif ($user['status'] == 2 && $user_data[0]['fieldset']==2){
        header('location: ../registration/marks.php');
    }elseif ($user['status'] == 2 && $user_data[0]['fieldset']==3){
        header('location: ../registration/thankyou.php');
    }elseif($user['status'] == 2){
        header('location: ../registration/basicDetails.php');
    }


    //session
    // $authObject->createSession();

    //redirect to dashboard
    //header("location:/modules/dashboard");





    // //make DB Connection
    // include_once "../../core/DBController.php";
    // $dbConnector= new DBController();

    // //check coming users
    // $email=$_POST['email'];
    // $password=$_POST['password'];

    // // sql query
    // $query= "select * from ".DB_PREFIX."users where email=:email and password=:password";
    // $params= array(':email'=>$email, ':password'=>$password);

    // // running query
    // $stmt = $dbConnector->runQuery($query,$params);
    // //fetching values
    // $users= $dbConnector->fetchAllRows($stmt);

    // //printing the data
    // pr($users);
    // die();

    //make database connection
    //if true then craete session & redirect to dashboard
    //if false then need to set error key and redirect to login back
} else if ($_action == "process_register") {
    // loading user class
    $userObject = new RegistrationProcess();
    // receving email address
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    // print_r($_POST);
    // die();

    // checking user exists or not
    $user = $userObject->getUserByEmail($email);

    // if exists then redirect back with error
    if (!empty($user)) {
        header('location:/modules/auth/register.php?err=Hey ' . $email . ', already exists!');
        exit;
    }
    // if not exists then we are creating a new user.
    $stmt = $userObject->createUser($_POST);

    //sending email
    include_once "../../core/Emailer.php";
    $emailerObject = new Emailer();
    //3 second
    $emailerObject->sendEmail("Hey, admin new request for content writer signup","Hey, admin please check admin panel, there is a new request for approval");
    //3 second
    $emailerObject->sendEmail("Thanks for signup!","Hey, please checking your email box and spam folder , ASAP we will look into your application, we will notify you back.");


    // if user not exists then show the craeted successfull massage.
    if (isset($stmt)) {
        header('location:/modules/auth/register.php?msg=Hey ' . $email . ', Created Successfully. checking for approval.');
        exit;
    } else {
        header('location:/modules/auth/register.php?err=Hey ' . $email . ', There is an Issue!');
        exit;
    }
}elseif($_action=="send_reset_password_link"){
    $email=$_POST['email'];
    $userObj = new RegistrationProcess();
    $user=$userObj->getUserByEmail($email);
    if(empty($user)){
        header('location: /modules/auth/forgot-password.php?err=Hey '.$email.' doesn\'t exits in the database.');
        exit;   
    }

    // if they are here mean they are a valid user
    // save that forgot key
    $forgotKey=generateRandomAlphanumeric();

    //here we direct pass the parameter- query and param of insertQuery() funtion.
    $stmt=$userObj->insertQuery("update ".DB_PREFIX."users set forgot_key=:forgot_key where email=:email",[':forgot_key'=>$forgotKey,':email'=>$email]);
    if(!$userObj->rowCount($stmt)){
        header('location: /modules/auth/forgot-password.php?err=Hey '.$email.' there is an issue with the server, please try again.');
        exit;   
    }

    //craete a reset password link
    $resetPasswordLink = SITE_URL . "modules/auth/forgot-reset-password-link.php?forgotKey=" . $forgotKey . "&email=" . base64_encode($user['email']);
    //sending email
    include_once "../../core/Emailer.php";
    $emailerObject = new Emailer();
    //3 second
    $base64EncodeEmail=base64_encode($email);
    $emailerObject->sendEmail("Hey, ".$user['email']." Here is your password reset link","Here is your password <a href='".$resetPasswordLink."'>reset link</a>");
    header('location: /modules/auth/forgot-password-thankyou?email='.$base64EncodeEmail.'&err=Hey '.$email.' we have send one reset password link on your email please check and do the neeful.');
    exit; 


}elseif($_action=="update_user_password_with_forgot_key"){
    $email=base64_decode($_REQUEST['email']);
    $forgotKey=$_REQUEST['forgot_key'];
    //fetch the current user
    $userObject = new RegistrationProcess();

    //if someone has touched those encrypted values
    $user=$userObject->getUserByEmail($email);
    if(empty($user)){
        header('location: /modules/auth/forgot-password.php?err=sorry that link was expired please regenerate user.');
        exit;
    }

    if($user['forgot_key']!=$forgotKey){
        header('location: /modules/auth/forgot-password.php?err=sorry that link was expired please regenerate forgot key.');
        exit;
    }

    //if user is comming upto here, means nobody touched our hashed code.
    //run update command for password and send him on login page with sucess message.
    $password=$_REQUEST['password'];
    $stmt=$userObject->runQuery("update ".DB_PREFIX."users set password=:password where email=:email and forgot_key=:forgot_key",[':password'=>$password,':forgot_key'=>$forgotKey,':email'=>$email]);
    
    if(!$userObject->rowCount($stmt)){
        header('location: /modules/auth/forgot-password.php?err=Hey, unable to update password');
        exit;  
    }
    header('location: /modules/auth/login.php?err=Hey, password updated sucessfully please login');
    exit; 
}   







//Multi-Registration Form

$robj=new RegistrationProcess();
$user_data=$robj->getUserDetails();

//this is for update
if($_action=="basic_register" && isset($user_data[0]['id'])){//&& isset($user_data[0]['id'])){
    $mother_name = $_POST['mother_name'];
    $father_name = $_POST['father_name'];
    $dob = $_POST['dob'];
    $err = "";
    if($_POST['nationality']=="India" || $_POST['nationality']=="United Kingdom" || $_POST['nationality']=="United States" || $_POST['nationality']=="Canada"){
        $nationality = $_POST['nationality'];
    }else{
        $err .= "Enter a Valid Nationality <br>";
    }

    if (!preg_match('/^[a-zA-Z\s]+$/', $mother_name)) {
        $err .= "mother name must be an alphabetic <br>";
    }
    if (!preg_match('/^[a-zA-Z\s]+$/', $father_name)) {
        $err .= "father name must be an alphabetic <br>";
    }

    $dateOfBirth = new DateTime($dob);
    $currentDate = new DateTime();
    $age=$currentDate->diff($dateOfBirth)->y;
    if ($dateOfBirth >= $currentDate) {
        $err .= "Date of Birth Should not be a future Date <br>";
    }

    if (!empty($err)) {
        header("location: ../registration/basicDetails.php?err=$err");
        exit;
    }

    $authObject = new RegistrationProcess();
    $stmt = $authObject->updateBasic($_POST);

    if (isset($stmt)) {
        if($nationality=="India"){
            header('Location: ../registration/idVerify.php?age='.$age.'');
            exit;
        }else{
            header('Location: ../registration/marks.php');
            exit;
        }
    } else {
        header("location: ../registration/basicDetails.php?err=Basic details are not saved");
        exit;
    }

    //this is for insert
}elseif ($_action == "basic_register") {
    $mother_name = $_POST['mother_name'];
    $father_name = $_POST['father_name'];
    $dob = $_POST['dob'];
    $err = "";
    //practice using array
    if($_POST['nationality']=="India" || $_POST['nationality']=="United Kingdom" || $_POST['nationality']=="United States" || $_POST['nationality']=="Canada"){
        $nationality = $_POST['nationality'];
    }else{
        $err .= "Enter a Valid Nationality <br>";
    }
    $fieldset=$_POST['fieldset'];

    if (!preg_match('/^[a-zA-Z\s]+$/', $mother_name)) {
        $err .= "mother name must be an alphabetic <br>";
    }
    if (!preg_match('/^[a-zA-Z\s]+$/', $father_name)) {
        $err .= "father name must be an alphabetic <br>";
    }

    $dateOfBirth = new DateTime($dob);
    $currentDate = new DateTime();
    $age=$currentDate->diff($dateOfBirth)->y;
    if ($dateOfBirth >= $currentDate) {
        $err .= "Date of Birth Should not be a future Date <br>";
    }

    if (!empty($err)) {
        header("location: ../registration/basicDetails.php?err=$err");
        exit;
    }

    $authObject = new RegistrationProcess();
    $stmt = $authObject->Basic($_POST);

    if (isset($stmt)) {
        if($nationality=="India"){
            header('Location: ../registration/idVerify.php?age='.$age.'');
            exit;
        }else{
            header('Location: ../registration/marks.php');
            exit;
        }
    } else {
        header("location: ../registration/basicDetails.php?err=Basic details are not saved");
        exit;
    }
}
// if($_action=="basic_register" && isset($user_data[0]['id'])){
//     $mother_name = $_POST['mother_name'];
//     $father_name = $_POST['father_name'];
//     $dob = $_POST['dob'];
//     $nationality = $_POST['nationality'];


//     $err = "";
//     if (!preg_match('/^[a-zA-Z\s]+$/', $mother_name)) {
//         $err .= "mother name must be an alphabetic";
//     }
//     if (!preg_match('/^[a-zA-Z\s]+$/', $father_name)) {
//         $err .= "father name must be an alphabetic";
//     }

//     $dateOfBirth = new DateTime($dob);
//     $currentDate = new DateTime();
//     $age=$currentDate->diff($dateOfBirth)->y;
//     if ($dateOfBirth >= $currentDate) {
//         $err .= "Date of Birth Should not be a future Date";
//     }

//     if (!empty($err)) {
//         header("location: ../registration/basicDetails.php?err=$err");
//         exit;
//     }

//     $authObject = new RegistrationProcess();
//     $stmt = $authObject->updateBasic($_POST);

//     if (isset($stmt)) {
//         if($nationality=="India"){
//             header('Location: ../registration/idVerify.php?age='.$age.'');
//             exit;
//         }else{
//             header('Location: ../registration/marks.php');
//             exit;
//         }
//     } else {
//         header("location: ../registration/basicDetails.php?err=Basic details are not saved");
//         exit;
//     }

// }

if ($_action == "idverify_register") {

    $addhar = $_POST['addhar'];
    $pan = $_POST['pan'];
    $age=$_POST['age'];
    $fieldset=$_POST['fieldset'];
    
    // if($age<18){
    //     $err="hidden";
    // }

    $alen = strlen($addhar);
    $plen = strlen($pan);
    if (!is_numeric($addhar)) {
        $err .= "Aadhar number must be numeric <br>";
    } elseif ($alen != 12) {
        $err .= "Aadhar number must be 12 digits <br>";
    }
    
    
    if (!preg_match('/^[a-zA-Z0-9]+$/', $pan)) {
        $err .= "PAN number must be alphanumeric <br>";
    } elseif ($plen != 10) {
        $err .= "PAN number must be 10 characters <br>";
    }

    if (!empty($err)) {
        header("location: ../registration/idVerify.php?err=$err");
        exit();
    }

    $authObject = new RegistrationProcess();
    $stmt = $authObject->idVerification($_POST);

    if(isset($stmt)) {
        header("location: ../registration/marks.php");
        //print_r($_SESSION['authUser']);
    } else {
        header("location: ../registration/idVerify.php?err=Id Details Not saved");
        exit;
    }
}

if ($_action == "marks_register") {
    $ten = $_POST['ten'];
    $twelve = $_POST['twelve'];
    $graduation = $_POST['graduation'];
    $fieldset=$_POST['fieldset'];
    
    // $twelve_numeric = intval($twelve);
    // $graduation_numeric = intval($graduation);

    if (!is_double($ten) && !is_numeric($ten)) {
        $err .= "10th result must be a double or numeric value. <br>";
    } elseif ($ten < 1 || $ten >= 100) {
        $err .= "10th result must be between 1 and 100. <br>";
    }
    
    if (!is_double($twelve) && !is_numeric($twelve)) {
        $err .= "12th result must be a double or numeric value. <br>";
    } elseif ($twelve < 1 || $twelve >= 100) {
        $err .= "12th result must be between 1 and 100. <br>";
    }
    
    if (!is_double($graduation) && !is_numeric($graduation)) {
        $err .= "Graduation result must be a double or numeric value. <br>";
    } elseif ($graduation < 1 || $graduation >= 100) {
        $err .= "Graduation result must be between 1 and 100. <br>";
    }
    

    if (!empty($err)) {
        header("location: ../registration/marks.php?err=$err");
        exit;
    }

    $authObject = new RegistrationProcess();
    $stmt = $authObject->academicMarks($_POST);

    if (isset($stmt)) {
        header('location: ../registration/thankyou.php');
        //print_r($_SESSION['authUser']);
    } else {
        header("location: ../registration/marks.php?err=Marks Not saved");
        exit;
    }
}

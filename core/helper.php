<?php
    function pr($arr){
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }

    /**
 * isLogin() 
 * 
 * it checks either user is loggedIn or not
 * 
 * return Boolean
 */

 function isLogin(){
    if (isset($_SESSION['authUser'])){
        $status=$_SESSION['authUser']['status'];
        if ($status==1){
            return true;
        }else{
            return false;
        }
    }
 }

 function isLogin2(){
    if(isset($_SESSION['authUser'])){
        $status=$_SESSION['authUser']['status'];
        if ($status==2){
            return true;
        }else{
            return false;
        }
    }
 }

 function sessionNotSet(){
    if(!isset($_SESSION['authUser'])){
            return true;
        }else{
            return false;
        }
 }


function generateRandomAlphanumeric($length=6){
    //Define a string of all possible character.
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    //Get the length of character string
    $charactersLength = strlen($characters);

    //Initialize the random string
    $randomString = '';

    //Generate a random string of the specified length
    for($i = 0; $i<$length; $i++){
        $randomString .= $characters[rand(0,$charactersLength-1)];
    }

    return $randomString;
 }
?>
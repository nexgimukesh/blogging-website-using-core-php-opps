<?php
include_once "../../core/DBController.php";
class LoginProcess extends DBController{
    private $user;
    // Constructor method
    public function __construct() {
        $this->user = null;
        // Initialize the database connection when the object is created
        parent::__construct();
    }

    public function verifyLogin($formData){
        // check coming users
        $email = $formData['email'];
        $password = $formData['password'];

        $query = "SELECT * FROM ".DB_PREFIX."users WHERE email = :user_email AND password = :user_password";
        $params = array(':user_email' => $email, ':user_password' => $password);
       
        $stmt = $this->runQuery($query, $params);
        // fetching values 
        // print_r($stmt);
        // die();
        $users = $this->fetchAllRows($stmt);
        // print_r($users);
        // die();

        //echo "in authclass.php";    
        //pr($users);

        if(!empty($users)){
            $this->user = $users[0];
        }

        //what is the use of this.
        if(!empty($users)){
            $this->user = [
                'id' => $users[0]['id'],
                'first_name' => $users[0]['first_name'],
                'last_name' => $users[0]['last_name'],
                'email' => $users[0]['email'],
                'status' => $users[0]['status']
            ];
        }
    }

    public function getCurrentUser(){
        return $this->user;
    }

    public function createSession(){
       return $_SESSION['authUser'] = $this->user;
    }

}
<?php
if (!isset($skip_session_start)) {
    session_start();
}
include_once "../../core/DBController.php";
include_once "../auth/loginProcess.php";
class RegistrationProcess extends DBController{
    private $user;
    // Constructor method
    public function __construct() {
        $this->user = null;
        // Initialize the database connection when the object is created
        parent::__construct();
    }
 

    public function getUserByEmail($email){

        $query = "SELECT * FROM ".DB_PREFIX."users WHERE email = :email";
        $params = array(':email' => $email);
       
        $stmt = $this->runQuery($query, $params);
        // fetching values 
        $users = $this->fetchAllRows($stmt);

        if(!empty($users)){
            return $users[0];
        }
        // return [];
        return null;
    }


    /**
     * create user
     */
    public function createUser($formData){
        // receiving full name as breaking down that into
        $full_name = $formData['full_name'];
        $full_name = explode(' ', $full_name);
        // first name 
        $first_name = $full_name[0];
        // last name
        $last_name = isset($full_name[1]) ? $full_name[1] : null;
        
        $email = $formData['email'];
        $password = $formData['password']; 

        // 0 - Disabled/Rejected
        // 1 - Approved
        // 2 - Waiting for approval

        $query = "insert into ".DB_PREFIX."users (email, first_name, last_name, status, password) VALUES (:email, :first_name, :last_name, :status, :password)";
        $params = array(
            ':first_name'=>$first_name, 
            ':last_name'=>$last_name, 
            ':status'=>2,
            ':email' => $email, 
            ':password' => $password
        );
       return $this->insertQuery($query, $params);
    }


    public function notifyToAdmin(){

    }

    public function notifyToUser(){
        
    }





    public function Basic($formData) {

            $mother_name = $formData['mother_name'];
            $father_name = $formData['father_name'];
            $dob = $formData['dob'];
            $nationality = $formData['nationality'];
            $fieldset=$formData['fieldset'];
            $id = $_SESSION['authUser']['id'];
            

        $query = "INSERT INTO multi_step_registration 
                  (user_id, mother_name, father_name, dob, nationality,fieldset) 
                  VALUES (:userid, :mothername, :fathername, :dob, :nationality, :fieldset)";
        $params = array(
            ':userid' => $id,
            ':mothername' => $mother_name,
            ':fathername' => $father_name,
            ':dob' => $dob,
            ':nationality' => $nationality,
            ':fieldset' => $fieldset
        );
        return $this->insertQuery($query, $params);
    }


    public function updateBasic($formData){
            $mother_name = $formData['mother_name'];
            $father_name = $formData['father_name'];
            $dob = $formData['dob'];
            $nationality = $formData['nationality'];
            $id = $_SESSION['authUser']['id'];

            $query = "UPDATE multi_step_registration SET
            mother_name = :mother_name, father_name = :father_name, dob = :dob, nationality = :nationality
            WHERE
            user_id = {$id}";
    
        $params = array(
            ':mother_name' => $mother_name,
            ':father_name' => $father_name, 
            ':dob' => $dob,
            ':nationality' => $nationality 
        );
        return $this->insertQuery($query, $params);
    }


    public function idVerification($formData) {

        $addhar = $formData['addhar'];
        $pan = $formData['pan'];
        $fieldset=$formData['fieldset'];
        $id = $_SESSION['authUser']['id'];
    
        $query = "UPDATE multi_step_registration SET
          addhar = :addhar, pan = :pan, fieldset = :fieldset
          WHERE
          user_id = {$id}";
    
        $params = array(
            ':addhar' => $addhar,
            ':pan' => $pan,  
            ':fieldset' => $fieldset
        );

        return $this->insertQuery($query, $params);
    }


    public function academicMarks($formData) {

        $ten = $formData['ten'];
        $twelve = $formData['twelve'];
        $graduation = $formData['graduation'];
        $fieldset=$formData['fieldset'];
        
        $id = $_SESSION['authUser']['id'];
    
        $query = "UPDATE multi_step_registration SET
          ten = :ten, twelve = :twelve, graduation = :graduation, fieldset = :fieldset
          WHERE
          user_id = {$id}";

        $params = array(
            ':ten' => $ten,
            ':twelve' => $twelve,
            ':graduation' =>$graduation,
            ':fieldset' => $fieldset
        );

        return $this->insertQuery($query, $params);
    }


    public function getUserDetails(){
        $sid=$_SESSION['authUser']['id'];
        $param=null;
        $query="select * from multi_step_registration where user_id={$sid}";
        $stmt=$this->runQuery($query,$param);
        $user_details=$this->fetchAllRows($stmt);
        return $user_details;
    }

    

    public function getUserAge(){
        $sid=$_SESSION['authUser']['id'];
        $param=null;
        $query="select dob from multi_step_registration where user_id={$sid}";
        $stmt=$this->runQuery($query,$param);
        $user_details=$this->fetchAllRows($stmt);
        $dob=$user_details[0]['dob'];
        $dateOfBirth = new DateTime($dob);
        $currentDate = new DateTime();
        $age=$currentDate->diff($dateOfBirth)->y;
        return $age;
    }

}
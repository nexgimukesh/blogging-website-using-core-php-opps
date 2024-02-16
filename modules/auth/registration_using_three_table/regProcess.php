<?php
session_start();
include_once "../../core/DBController.php";
include_once "../auth/loginProcess.php";

class RegistrationProcess extends DBController {
    private $user;

    // Constructor method
    public function __construct() {
        $this->user = null;
        // Initialize the database connection when the object is created
        parent::__construct();
    }

    /**
     * create user
     */
    
    public function basicDetails($formData) {
        // pr($formData);
        // die();
        $mother_name = $formData['mother_name'];
        $father_name = $formData['father_name'];
        $dob = $formData['dob'];
        $nationality = $formData['nationality'];
        $id = $formData['uid'];
        $filteredId = preg_replace("/[^0-9]/", "", $id); // Remove non-numeric characters
        $uid = (int)$filteredId;

        // Debugging statements
        echo "Original user ID: $id<br>";
        echo "Filtered user ID: $filteredId<br>";
        echo "Casted user ID: $uid<br>";
        die();

        $query = "INSERT INTO basic_details 
                  (user_id, mother_name, father_name, dob, nationality) 
                  VALUES (:userid, :mothername, :fathername, :dob, :nationality)";
        $params = array(
            ':userid' => $uid,
            ':mothername' => $mother_name,
            ':fathername' => $father_name,
            ':dob' => $dob,
            ':nationality' => $nationality
        );
        return $this->insertQuery($query, $params);
    }

    public function showUser($param){
        $query="select * from basic_details user_id=$param";
        $stmt=$this->runQuery($query,$param);
        $users= $this->fetchAllRows($stmt);
        return $users;
    }

    public function idVerify($formData) {

        $addhar = $formData['addhar'];
        $pan = $formData['pan'];
        $id = $formData['uid'];
        $filteredId = preg_replace("/[^0-9]/", "", $id); // Remove non-numeric characters
        $sid = (int)$filteredId;

        $u =new RegistrationProcess();
        $user=$u->showUser($sid);
        $user_id=$user[0]['id'];
        // print_r($user_id);
        // die();
        $query = "INSERT INTO id_varification (basic_id, addhar, pan) 
                  VALUES (:basicid, :addhar, :pan)";
        $params = array(
            ':basicid' => $user_id,
            ':addhar' => $addhar,
            ':pan' => $pan
        );

        return $this->insertQuery($query, $params);
    }


    public function marks($formData) {

        $ten = $formData['ten'];
        $twelve = $formData['twelve'];
        $graduation = $formData['graduation'];
        $id=0;
        $u =new RegistrationProcess();
        $user=$u->showUser($id);
        $user_id=$user[0]['id'];
        // print_r($user_id);
        // die();
        $query = "INSERT INTO marks (basic_id, ten, twelve, graduation) 
                  VALUES (:basicid, :ten, :twelve, :graduation)";
        $params = array(
            ':basicid' => $user_id,
            ':ten' => $ten,
            ':twelve' => $twelve,
            ':graduation' =>$graduation
        );

        return $this->insertQuery($query, $params);
    }

}
?>

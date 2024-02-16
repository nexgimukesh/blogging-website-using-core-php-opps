<?php
    include_once "../../core/DBController.php";
    include_once "../../core/constants.php";
    include_once "../../core/helper.php";

    class DisplayUser extends DBController{
        private $user;

        public function __construct()
        {
            $this->user = null;
            // Initialize the database connection when the object is created
            parent::__construct();
        }

        public function showUser(){
            $param=null;
            $query="select * from ".DB_PREFIX."users";
            $stmt=$this->runQuery($query,$param);
            $users= $this->fetchAllRows($stmt);
            return $users;
        }
    }
?>
<?php
require_once("config.php");

class Database {

    public $connection;

    function __construct() {
        $this->open_db_conn();
    }

    public function open_db_conn() {

        $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if(mysqli_connect_errno()) {
            die("DB connection failed" . mysqli_error());
        }
    }

}
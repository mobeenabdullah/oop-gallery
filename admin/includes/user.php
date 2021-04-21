<?php

class User {

    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;

    public static function find_all_users() {
        return self::find_this_query("SELECT * FROM users");
    }

    public static function find_user_by_id($user_id) {
        $result_array = self::find_this_query("SELECT * FROM users WHERE id=$user_id LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function find_this_query($sql) {
        global $database;
        $result_set = $database->query($sql);
        $the_obj_array = array();
        while($row = mysqli_fetch_array($result_set)) {
            $the_obj_array[] = self::instantation($row);
        }
        return $the_obj_array;
    }

    public static function verify_user($username, $password) {
        global $database;
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "SELECT * FROM users WHERE ";
        $sql .= "username = '{$username}' ";
        $sql .= "AND password= '{$password}' ";
        $sql .= "LIMIT 1";

        $result_array = self::find_this_query($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function instantation($record) {
        $the_obj = new self;
        foreach ($record as $attribute => $value) {
            if($the_obj->has_the_attribute($attribute)) {
                $the_obj->$attribute = $value;
            }
        }
        return $the_obj;
    }

    private function has_the_attribute($attribute) {
        $obj_props = get_object_vars($this);
        return array_key_exists($attribute, $obj_props);
    }

}
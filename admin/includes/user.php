<?php

class User {

    protected static $db_table = "users";
    protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name');
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

    protected function properties() {
        $properties = array();

        foreach (self::$db_table_fields as $db_field) {
            if(property_exists($this, $db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }

        return $properties;

    }

    protected function clean_properties() {
        global $database;

        $clean_properties = array();

        foreach ($this->properties() as $key => $value) {
            $clean_properties[$key] = $database->escape_string($value);
        }

        return $clean_properties;
    }

    public function save() {
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function create() {
        global $database;

        $properties = $this->properties();

        $sql = "INSERT INTO " . self::$db_table . "(" . implode(",", array_keys($properties)) . ")";
        $sql .= "VALUES ('". implode("','", array_values($properties)) ."')";

        if($database->query($sql)) {
            $this->id = $database->the_insert_id();
            return true;
        } else {
            return false;
        }
    }

    public function update() {
        global $database;

        $properties = $this->properties();

        $properties_pairs = array();

        foreach ($properties as $key => $value) {
            $properties_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE " . self::$db_table . " SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= " WHERE id= " . $database->escape_string($this->id);

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    public function delete() {
        global $database;

        $sql = "DELETE FROM " . self::$db_table;
        $sql .= " WHERE id= " . $database->escape_string($this->id);
        $sql .= " LIMIT 1";

        //print_r($sql); exit;

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

}
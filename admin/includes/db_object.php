<?php

class Db_object {

    public static function find_all() {
        return static::find_by_query("SELECT * FROM " . static::$db_table);
    }

    public static function find_by_id($user_id) {
        $result_array = static::find_by_query("SELECT * FROM ". static::$db_table ." WHERE id=$user_id LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function find_by_query($sql) {
        global $database;
        $result_set = $database->query($sql);
        $the_obj_array = array();
        while($row = mysqli_fetch_array($result_set)) {
            $the_obj_array[] = static::instantiation($row);
        }
        return $the_obj_array;
    }

    public static function instantiation($record) {

        $calling_class = get_called_class();

        $the_obj = new $calling_class;
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

        foreach (static::$db_table_fields as $db_field) {
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

        $sql = "INSERT INTO " . static::$db_table . "(" . implode(",", array_keys($properties)) . ")";
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

        $sql = "UPDATE " . static::$db_table . " SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= " WHERE id= " . $database->escape_string($this->id);

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    public function delete() {
        global $database;

        $sql = "DELETE FROM " . static::$db_table;
        $sql .= " WHERE id= " . $database->escape_string($this->id);
        $sql .= " LIMIT 1";

        //print_r($sql); exit;

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

}
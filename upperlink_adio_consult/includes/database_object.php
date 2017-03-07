<?php
  /*
    If it's going to need the database, then it's probaly smart to require it before we start.
  */
  require_once(LIB_PATH.DS."database.php");

  class DatabaseObject {

    protected static $table_name = "users";
    protected static $db_fields = array();

    // common database methods
    public static function find_all() {
      return static::find_by_sql("SELECT * FROM " . static::$table_name);
    }

    public static function find_by_id($id=0){
      global $database;
      $result_array = static::find_by_sql("SELECT * FROM "  . static::$table_name . " WHERE id = " . $database->escape_value($id) . " LIMIT 1");

      return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function find_by_sql($sql = "") {
      global $database;
      $result_set = $database->query($sql);
      $object_array = array();
      while ($row = $database->fetch_assoc($result_set)) {
        $object_array[] = static::instantiate($row);
      }
      return $object_array;
    }

    private static function instantiate($record) {
      $class_name = get_called_class();
      $object = new $class_name;

      foreach ($record as $attribute => $value) {
        if ($object->has_attribute($attribute)) {
          $object->$attribute = $value;
        }
      }
      return $object;
    }

    private function has_attribute($attribute) {

      $object_vars = $this->attributes();

      return array_key_exists($attribute, $object_vars);
    }

    protected function attributes() {
      // return an array of attribute names and their values
      $attributes = array();
      foreach(static::$db_fields AS $field) {
        if(property_exists($this, $field)) {
          $attributes[$field] = $this->$field;
        }
      }
      return $attributes;
    }

    protected function sanitized_attributes() {
      global $database;
      $clean_attributes = array();
      // sanitize the values before submitting
      // Note: does not alter the actual value of each attributes

      foreach($this->attributes() AS $key => $value) {
        $clean_attributes[$key] = $database->escape_value($value);
      }

      return $clean_attributes;
    }

    public function save() {
      // A new record won't have an id yet
      return isset($this->id) ? $this->update() : $this->create();
    }

    public function create() {
      global $database;

      $attributes = $this->sanitized_attributes();
      $sql = "INSERT INTO " . static::$table_name . " (";
      $sql .= join(", ", array_keys($attributes));
      $sql .= ") VALUES ('";
      $sql .= join("', '", array_values($attributes));
      $sql .= "')";
      if($database->query($sql)) {
        $this->id = $database->insert_id();
        return TRUE;
      } else {
        return FALSE;
      }
    }

    public function update() {
      global $database;

      $attributes = $this->sanitized_attributes();
      $attribute_pairs = array();
      foreach($attributes AS $key => $value) {
        $attribute_pairs[] = "{$key} = '{$value}'";
      }
      $sql = "UPDATE INTO " . static::$table_name . " SET ";
      $sql .= join(", ", $attribute_pairs);
      $sql .= " WHERE user_id = '" . $database->escape_value($this->id) . "'";

      $database->query($sql);
      return ($database->affected_rows() == 1) ? TRUE : FALSE;
    }

    public function delete() {
      global $database;

      $sql = "DELETE FROM " . static::$table_name;
      $sql .= " WHERE id = " . $database->escape_value($this->id);
      $sql .= " LIMIT 1";
      $database->query($sql);
      return ($database->affected_rows() == 1) ? TRUE : FALSE;
    }

    public static function count() {
      global $database;

      $sql = "SELECT COUNT(*) FROM " . static::$table_name;
      $database->query($sql);
      $result = $database->fetch_assoc();
      return array_shift($result);
    }

  }
?>
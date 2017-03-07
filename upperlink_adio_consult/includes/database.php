<?php
	require_once (LIB_PATH.DS."config.php");

	class MySQLDatabase{

		private $mysqli;
		public $last_query;
    private $result_set;

		function __construct() {
			$this->open_connection();
		}

		public function open_connection() {
			$this->mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

			if($this->mysqli->connect_errno) {
				die("Database connection failed: " . $this->mysqli->connect_error);
			}
		}

		public function close_connection() {
			if(isset($this->mysqli)) {
				$this->mysqli->close();
				unset($this->mysqli);
			}
		}

		public function query($sql) {
			$this->last_query = $sql;
			$this->result_set = $result = $this->mysqli->query($sql) or $this->confirm_query();
			return $result;
		}

		public function escape_value($value) {
			return $this->mysqli->real_escape_string($value);
		}

		public function fetch_assoc($result_set = NULL){
			return $this->result_set->fetch_assoc();
		}

		public function num_rows($result_set = NULL) {
			return $this->result_set->num_rows;
		}

		public function insert_id() {
			return $this->mysqli->insert_id;
		}

		public function affected_rows() {
			return $this->mysqli->affected_rows;
		}

		private function confirm_query() {
			$output = "Database query failed: " . $this->mysqli->error . "<br><br>";
			$output .= "Last SQL query: " . $this->last_query;
			die($output);
		}
	}

	$database = new MySQLDatabase();
	$db =& $database;

?>
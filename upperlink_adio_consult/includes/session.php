<?php
	/**
	* A Class to help work with Sessions
	* In our case, primarily to manage logging users in and out
	*
	* Keep in mind when working with sessions that it is generally 
	*	inadvisable to store DB-related objects in sessions
	*/
	class Session {
		
		private $logged_in = false;
		public $user_id;
    private $message;

		function __construct() {
			session_start();
			$this->check_login();
      $this->check_message();
			if($this->logged_in) {
				// actions to take right away if user is logged in 
			} else {
				// actions to take right away if user is not logged in
			}
		}

		public function is_logged_in() {
			return $this->logged_in;
		}

		public function login($user) {
			// database should find user based on username/password
			if($user) {
				$this->user_id = $_SESSION["user_id"] = $user->id;
				$this->logged_in = true;
			}
		}

		public function logout() {
      $user = User::find_by_id($this->user_id);
			unset($_SESSION["user_id"]);
			unset($this->user_id);
			$this->logged_in = false;
		}

    public function message($msg = "") {
      if(!empty($msg)) {
        // then this is "set message"
        // make sure you understand why $this->message = $msg wouldn't work
        $_SESSION["message"] = $msg;
      } else {
        // then this is "get message"
        return $this->message;
      }
    }
		private function check_login() {
			if(isset($_SESSION["user_id"])) {
				$this->user_id = $_SESSION["user_id"];
				$this->logged_in = true;
			} else {
				unset($this->user_id);
				$this->logged_in = false;
			}
		}

    private function check_message() {
      // is there a message stored in the session?
      if(isset($_SESSION["message"])){
        // Add it as an attribute and erase the stored version
        $this->message = $_SESSION["message"];
        unset($_SESSION["message"]);
      } else {
        $this->message = "";
      }
    }
	}

	$session = new Session();
  $message = $session->message();

?>
<?php

  require_once(LIB_PATH.DS."database.php");

  class Applicant extends DatabaseObject {
    protected static $table_name = "applicants";
    protected static $db_fields = array('id', 'first_name', 'surname', 'phone', 'email', 'passport_path');
    public $id;
    public $first_name;
    public $surname;
    public $phone;
    public $email;
    public $passport_path;

    private $temp_path;
    protected $upload_dir = "uploads";
    public $errors = array();

    protected $upload_errors = array(
      UPLOAD_ERR_OK => "No errors.",
      UPLOAD_ERR_INI_SIZE => "Larger than upload_max_filesize.",
      UPLOAD_ERR_FORM_SIZE => "Larger than form MAX_FILE_SIZE.",
      UPLOAD_ERR_PARTIAL => "Partial upload.",
      UPLOAD_ERR_NO_FILE => "No file.",
      UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
      UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
      UPLOAD_ERR_EXTENSION => "File upload stopped by extension."
    );

    // Pass in $_FILE['uploaded_file'] as an argument
    public function attach_file($file) {
      // Perform error checking on the form parameters
      if(!$file || empty($file) || !is_array($file)) {
        // error: nothing uploaded or wrong argument usage
        $this->errors[] = "No file was uploaded.";
        return FALSE;
      } elseif ($file['error'] != 0 ) {
        // error: report what PHP says went wrong
        $this->errors[] = $this->upload_errors[$file['error']];
        return FALSE;
      } else {
        // Set object attributes to the form parameters.
        $this->temp_path  = $file['tmp_name'];
        $this->passport_path  = basename($file['name']);

        return TRUE;
      }
    }

    public function save() {
      // A new record won't have an id yet
      if(isset($this->id)) {
        // Really just to update the caption
        $this->update();
      } else {
        // Make sure there are no errors
        if(!empty($this->errors)) { return FALSE; }

        // Can't save without filename and temp location
        if(empty($this->passport_path) || empty($this->temp_path)) {
          $this->errors[] = "The file location was not available.";
          return FALSE;
        }

        // Determine the target_path
        $target_path = SITE_ROOT.DS.'public'.DS.$this->upload_dir.DS.$this->passport_path;

        // Make sure a file doesn't already exist in the target location
        if(file_exists($target_path)) {
          $this->errors[] = "The file {$this->passport_path} already exists.";
          return FALSE;
        }

        // Attempt to move the file
        if(move_uploaded_file($this->temp_path, $target_path)) {
          // Success
          // Save a corresponding entry to the database
          if($this->create()){
            // We are done with temp_path, the file isn't there anymore
            unset($this->temp_path);
            return TRUE;
          }
        } else {
          // File was not saved.
          $this->errors[] = "The file upload failed, possible due to incorrect permissions on the upload folder.";
          return FALSE;
        }

      }

    }


  }

?>
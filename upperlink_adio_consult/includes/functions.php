<?php
  function include_layout_template($template = "", $title="", $page="", $sub_page=NULL){
    include SITE_ROOT.DS."public".DS."layouts".DS.$template;
  }

  function redirect_to($location=NULL) {
    if($location != NULL) {
      header("Location: {$location}");
      exit;
    }
  }

  function output_message($message="", $alert_type = 1, $sub_messages = NULL) {
    if(!empty($message)) {
      switch ($alert_type) {
        case 1 : $alert_class = "alert-success";
          break;
        case 2 : $alert_class = "alert-info";
          break;
        case 3 : $alert_class = "alert-warning";
          break;
        case 4: $alert_class = "alert-danger";
          break;
        default : $alert_class = "alert-success";
          break;
      }
      $output =  "<div class=\"alert {$alert_class} alert-dismissable\">
									<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\"> &times; </button>
									<div>{$message}";
      if($sub_messages){
        $output .= "<ul>";
        foreach($sub_messages as $sub_message ){
          $output .= "<li>{$sub_message}</li>";
        }
        $output .= "</ul>";
      }
      $output .= "</div>
								</div>";

      echo $output;
    } else {
      echo "";
    }
  }

  function __autoload($class_name) {
    $class_name = strtolower($class_name);
    $path = LIB_PATH.DS."{$class_name}.php";
    if (file_exists($path)){
      require_once $path;
    } else {
      die("The file {$class_name}.php could not be found.");
    }
  }

  function required_fields($fields){
    foreach ($fields as $key => $field) {
      if($field == ""){
        $error_msg[$key] = "{$key} is required.";
      }
    }
    if(!empty($error_msg)){
      return $error_msg;
    }else{ return array(); }
  }
?>
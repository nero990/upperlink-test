<?php
  defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);

  $document_root = str_replace("/", DS, $_SERVER["DOCUMENT_ROOT"]);
  defined("SITE_ROOT") ? null : define("SITE_ROOT", $document_root.DS.DS."upperlink_adio_consult");
  defined("LIB_PATH") ? null : define("LIB_PATH", SITE_ROOT.DS."includes");

  // load config files first
  require_once LIB_PATH.DS."config.php";

  // load basic functions next so that everything after can use them
  require_once LIB_PATH.DS."functions.php";

  // load core objects
  require_once LIB_PATH.DS."session.php";
  require_once LIB_PATH.DS."database.php";
  require_once LIB_PATH.DS."database_object.php";

  // load database-related classes
  require_once LIB_PATH.DS."applicant.php";
  require_once LIB_PATH.DS."user.php";
?>
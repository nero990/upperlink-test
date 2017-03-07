<?php ob_start(); ?>
<?php
	// Database constants
	defined("DB_SERVER") ? null : define("DB_SERVER", "localhost");
	defined("DB_USER") ? null : define("DB_USER", "root");
	defined("DB_PASS") ? null : define("DB_PASS", "");
	defined("DB_NAME") ? null : define("DB_NAME", "db_adio_consult");

	date_default_timezone_set("Africa/Lagos");
?>
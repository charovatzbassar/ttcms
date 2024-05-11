<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED));

define('DB_HOST', 'localhost');
define('DB_NAME', 'ttcms');
define('DB_USER', 'root');
define('DB_PORT', 3306);
define('DB_PASS', 'Paradigma1230!');
define('JWT_SECRET', '42d7d73955128cc016f5cd747dde11e3882cd7b4157ec9a3f6c5f09a622fd27d');

?>
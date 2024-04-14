<?php

require './vendor/autoload.php';
require_once dirname(__FILE__)."/rest/dao/MemberDao.class.php";
require_once dirname(__FILE__)."/rest/services/MemberService.class.php";
require_once dirname(__FILE__)."/rest/controllers/MemberController.php";
require_once dirname(__FILE__)."/rest/controllers/RegistrationController.php";
require_once dirname(__FILE__)."/rest/controllers/TournamentController.php";
require_once dirname(__FILE__)."/rest/controllers/ResultController.php";
require_once dirname(__FILE__)."/rest/controllers/UserController.php";


Flight::start();

?>
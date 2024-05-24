<?php

require './vendor/autoload.php';

Flight::before('start', function(&$params, &$output){
    header('Access-Control-Allow-Origin: https://lionfish-app-vc4vk.ondigitalocean.app');
    header('Access-Control-Allow-Methods: HEAD, GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Request, Origin, Content-Type, Authorization, X-Requested-With, Accept');
    header('Access-Control-Allow-Credentials: true');
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        // header('HTTP/1.1 204 No Content');
        // header('Content-Length: 0');
        exit(0);
    }
});


require_once dirname(__FILE__)."/rest/middleware/AuthMiddleware.php";
require_once dirname(__FILE__)."/rest/dao/MemberDao.class.php";
require_once dirname(__FILE__)."/rest/services/MemberService.class.php";
require_once dirname(__FILE__)."/rest/dao/UserDao.class.php";
require_once dirname(__FILE__)."/rest/services/UserService.class.php";
require_once dirname(__FILE__)."/rest/dao/RegistrationDao.class.php";
require_once dirname(__FILE__)."/rest/services/RegistrationService.class.php";
require_once dirname(__FILE__)."/rest/dao/ResultDao.class.php";
require_once dirname(__FILE__)."/rest/services/ResultService.class.php";
require_once dirname(__FILE__)."/rest/dao/TournamentDao.class.php";
require_once dirname(__FILE__)."/rest/services/TournamentService.class.php";
require_once dirname(__FILE__)."/rest/dao/TournamentCategoryDao.class.php";
require_once dirname(__FILE__)."/rest/services/TournamentCategoryService.class.php";
require_once dirname(__FILE__)."/rest/controllers/MemberController.php";
require_once dirname(__FILE__)."/rest/controllers/RegistrationController.php";
require_once dirname(__FILE__)."/rest/controllers/TournamentController.php";
require_once dirname(__FILE__)."/rest/controllers/ResultController.php";
require_once dirname(__FILE__)."/rest/controllers/UserController.php";
require_once dirname(__FILE__)."/rest/controllers/TournamentCategoryController.php";


Flight::start();

?>
<?php 

date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_TIME, 'pt_BR.utf-8', 'portuguese');

define('MODEL_PATH', realpath(dirname(__FILE__). '/../model'));
define('CONTROLLER_PATH', realpath(dirname(__FILE__). '/../controller'));
define('DAO_PATH', realpath(dirname(__FILE__). '/../dao'));
define('LIBS_PATH', realpath(dirname(__FILE__). '/../libs'));

require_once(realpath(MODEL_PATH. '/Model.php'));
require_once(realpath(MODEL_PATH. '/User.php'));

require_once(realpath(LIBS_PATH. '/php-jwt/src/BeforeValidException.php'));
require_once(realpath(LIBS_PATH. '/php-jwt/src/ExpiredException.php'));
require_once(realpath(LIBS_PATH. '/php-jwt/src/SignatureInvalidException.php'));
require_once(realpath(LIBS_PATH. '/php-jwt/src/JWT.php'));

require_once(realpath(CONTROLLER_PATH. '/Controller.php'));
require_once(realpath(CONTROLLER_PATH. '/UserController.php'));
require_once(realpath(CONTROLLER_PATH. '/MessageController.php'));
require_once(realpath(CONTROLLER_PATH. '/Auth.php'));

require_once(realpath(DAO_PATH. '/DAO.php'));
require_once(realpath(DAO_PATH. '/UserDAO.php'));
require_once(realpath(DAO_PATH. '/MessageDAO.php'));

require_once(realpath('../vendor/autoload.php'));
require_once(realpath(dirname(__FILE__). '/../config/database.php'));

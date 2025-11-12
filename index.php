<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


// Tangani OPTIONS request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'routes.php';
require_once 'Router.php';
require_once 'BaseResponse.php';
require_once 'UserTokenVerifier.php';

require_once 'config\Database.php';

require_once 'authentication\controllers\UserRegister.php';
require_once 'authentication\controllers\UserLogin.php';
require_once 'authentication\controllers\UserLogout.php';
require_once 'authentication\controllers\UserForgotPassword.php';
require_once 'authentication\controllers\UserResetPassword.php';
require_once 'authentication\models\User.php';
require_once 'authentication\models\UserForgot.php';
require_once 'authentication\models\UserToken.php';
require_once 'authentication\requests\UserForgotPasswordRequest.php';
require_once 'authentication\requests\UserResetPasswordRequest.php';
require_once 'authentication\requests\UserRegisterRequest.php';
require_once 'authentication\requests\UserLoginRequest.php';

require_once 'userProfile\models\UserProfile.php';
require_once 'userProfile\controllers\CreateUserProfile.php';
require_once 'userProfile\controllers\GetUserProfile.php';
require_once 'userProfile\controllers\GetAllUserProfile.php';
require_once 'userProfile\controllers\UpdateUserProfile.php';
require_once 'userProfile\requests\UpdateUserProfileRequest.php';

header('Content-Type: application/json');

$db = new Database();
$connection = $db->getConnection();

$router = new Router($connection, $routes);
$router->handleRequest();

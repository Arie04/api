<?php
$routes = [
    // Auth
    [
        'method' => 'POST',
        'path' => 'auth/register',
        'controller' => 'UserRegister',
        'action' => 'userRegister',
        'requiresToken' => false,
        'requiresBody' => true,
    ],
    [
        'method' => 'POST',
        'path' => 'auth/login',
        'controller' => 'UserLogin',
        'action' => 'userLogin',
        'requiresToken' => false,
        'requiresBody' => true,
    ],
    [
        'method' => 'POST',
        'path' => 'auth/logout',
        'controller' => 'UserLogout',
        'action' => 'userLogout',
        'requiresToken' => true,
        'requiresBody' => false,
    ],
    [
        'method' => 'POST',
        'path' => 'auth/forgot-password',
        'controller' => 'UserForgotPassword',
        'action' => 'forgotPassword',
        'requiresToken' => false,
        'requiresBody' => true,
    ],
    [
        'method' => 'POST',
        'path' => 'auth/reset-password/{UserId}',
        'controller' => 'UserResetPassword',
        'action' => 'resetPassword',
        'requiresToken' => false,
        'requiresBody' => true,
    ],
    // profile management
    [
        'method' => 'GET',
        'path' => 'user-profile/profile',
        'controller' => 'GetUserProfile',
        'action' => 'getUserProfile',
        'requiresToken' => true,
        'requiresBody' => false,
    ],
    [
        'method' => 'GET',
        'path' => 'user-profile/user-profiles',
        'controller' => 'GetAllUserProfile',
        'action' => 'getAllUserProfile',
        'requiresToken' => false,
        'requiresBody' => false,
    ],
    [
        'method' => 'PUT',
        'path' => 'user-profile/profile',
        'controller' => 'UpdateUserProfile',
        'action' => 'updateUserProfile',
        'requiresToken' => true,
        'requiresBody' => true,
    ],
    // prediction
    [
        'method' => 'POST',
        'path' => 'prediction/predict',
        'controller' => 'Predict',
        'action' => 'predict',
        'requiresToken' => false,
        'requiresBody' => true,
    ],
    [
        'method' => 'GET',
        'path' => 'prediction/history',
        'controller' => 'GetAllHistory',
        'action' => 'getAllHistory',
        'requiresToken' => false,
        'requiresBody' => false,
    ]
];

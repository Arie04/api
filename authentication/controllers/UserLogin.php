<?php

class UserLogin {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function userLogin($data) {
        $request = new UserLoginRequest();
        $isRequestValid = $request->validate();
        if (!$isRequestValid){
            return BaseResponse::error($request->getErrors());
        }

        $user = new User($this->db);
        $user->Username = $data['Username'];
        $userData = $user->findByUsernameOrEmail();

        if (!$userData){
            return BaseResponse::error("Invalid username or password.") ;
        }

        $isVerifyPassword = password_verify($data['Password'], $userData['Password']);
        if (!$isVerifyPassword){
            return BaseResponse::error("Invalid username or password.") ;
        }

        $token = bin2hex(random_bytes(32));

        $userToken = new UserToken($this->db);
        $userToken->UserId = $userData['UserId'];
        $userToken->Token = $token;
        $userToken->createToken();

        $getUserToken = $userToken->findToken($token);
        $expireAt = $getUserToken['ExpireAt'];

        $responseData = [
            "token" => $token,
            "expireAt" => $expireAt,
            "isAdmin" => $userData['IsAdmin']
        ];

        return BaseResponse::success($responseData);
    }
}
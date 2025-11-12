<?php

class UserLogout {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function userLogout($token) {
        $userToken = new UserToken($this->db);
        $userToken->Token = $token;
        $validateToken = $userToken->findToken();

        if (!$validateToken){
            return BaseResponse::error("Invalid token");
        }
        
        $logout = $userToken->logoutToken();
        if (!$logout) {
            return BaseResponse::unauthorize();
        }

        return BaseResponse::success("Logout successful");
    }
}
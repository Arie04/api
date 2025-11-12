<?php

class UserTokenVerifier {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function userTokenVerifier($token) {
        $userToken = new UserToken($this->db);
        $userToken->Token = $token;

        $userId = $userToken->getUserIdByToken();
        if (!$userId) {
            return BaseResponse::error("Invalid token");
        }

        error_log($userId);
        return $userId;
    }
}
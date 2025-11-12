<?php

class GetUserProfile {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUserProfile($token) {
        $userTokenVerifier = new UserTokenVerifier($this->db);
        $userVerified = $userTokenVerifier->userTokenVerifier($token);
        if (!$userVerified) {
            return BaseResponse::unauthorize();
        }

        $userProfile = new UserProfile($this->db);
        $userProfile->UserId = $userVerified;
        $data = $userProfile->get();

        if (!$data) {
            return BaseResponse::error("Data not found");
        }

        return BaseResponse::success($data);
    }
}
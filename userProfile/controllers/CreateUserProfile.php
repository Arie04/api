<?php

class CreateUserProfile {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createUserProfile($username, $userId){
        $userProfile = new UserProfile($this->db);
        $userProfile->Name = $username;
        $userProfile->UserId = $userId;

        if (!$userProfile->create()) {
            return BaseResponse::error("Failed create profile");
        }
        
        return true;
    }
}
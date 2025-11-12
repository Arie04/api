<?php 

class GetAllUserProfile {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllUserProfile() {
        $userProfile = new UserProfile($this->db);
        $data = $userProfile->getAll();

        if (!$data) {
            return BaseResponse::error("Data not found");
        }

        $history = new History($this->db);

        foreach ($data as &$profile) {
            $profile['History'] = $history->getHistoryByUserId($profile['UserId']);
        }

        return BaseResponse::success($data);
    }
}
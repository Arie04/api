<?php

class UserRegister {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function userRegister($data) {
        $request = new UserRegisterRequest();
        if (!$request->validate()) {
            return BaseResponse::error($request->getErrors());
        }
        
        $user = new User($this->db);
        $user->Username = $data['Username'];
        $user->Email = $data['Email'];
        
        $existingUsername = $user->findByUsername();
        if ($existingUsername){
            return BaseResponse::error("Username already exists");
        }

        $existingEmail = $user->findByEmail();
        if ($existingEmail){
            return BaseResponse::error("Email already exists");
        }

        $password = $data['Password'];
        /*
        $isPasswordValid = (
            strlen($password) >= 8 && 
            preg_match('/[A-Z]/', $password) && 
            preg_match('/[a-z]/', $password) &&
            preg_match('/[0-9]/', $password)
        );
        if (!$isPasswordValid) {
            return BaseResponse::error("Min Length 8, Include A-Z, a-z, 0-9");
        }
        */
        
        $isConfirmPassword = $data['ConfirmPassword'] === $password;
        if (!$isConfirmPassword) {
            return BaseResponse::error("Invalid confirm password");
        }
        
        $user->Password = password_hash($password, PASSWORD_BCRYPT);
        $user->create();

        $userData = $user->findByUsernameAndEmail();
        $username = $data['Username'];
        $userId = $userData['UserId'];
        
        $newUserProfile = new CreateUserProfile($this->db);
        $createUserProfile = $newUserProfile->createUserProfile($username, $userId);
        
        if (!$createUserProfile) {
            return BaseResponse::error("Failed create profile");
        }

        return BaseResponse::success("Register success");
    }
}
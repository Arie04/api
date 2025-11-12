<?php

class UserResetPassword {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }

    public function resetPassword($data){
        $request = new UserResetPasswordRequest();

        if (!$request->validate()) {
            return BaseResponse::error($request->getErrors());
        }

        $user = new User($this->db);
        $userForgot = new UserForgot($this->db);
        $userForgot->Code = $data['Code'];

        $userForgotData = $userForgot->findByCode();
        
        if(!$userForgotData) {
            return BaseResponse::error("Invalid code");
        }

        $userForgot->useCode();

        $newPassword = $data['NewPassword'];
        
        $isPasswordValid = (
            strlen($newPassword) >= 8 && 
            preg_match('/[A-Z]/', $newPassword) && 
            preg_match('/[a-z]/', $newPassword) &&
            preg_match('/[0-9]/', $newPassword)
        );

        if (!$isPasswordValid) {
            return BaseResponse::error("Min Length 8, Include A-Z, a-z, 0-9");
        }
        
        $isConfirmPassword = $data['ConfirmPassword'] === $newPassword;
        if (!$isConfirmPassword) {
            return BaseResponse::error("Invalid confirm password");
        }

        $hashNewPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        $user->UserId = $userForgotData['UserId'];
        $user->Password = $hashNewPassword;
        $user->resetPassword();

        return BaseResponse::success("Forgot password success");
    }
}
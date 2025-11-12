<?php

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserForgotPassword {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function forgotPassword($data){
        $request = new UserForgotPasswordRequest($this->db);
        $isRequestValid = $request->validate();
        if (!$isRequestValid) {
            return BaseResponse::error($request->getErrors());
        }

        $user = new User($this->db);
        $user->Email = $data['Email'];
        $userData = $user->findByEmail();

        if(!$userData){
            return BaseResponse::error("Email not found");
        }

        $code = strtoupper(bin2hex(random_bytes(3)));

        $this::sentEmail($userData['Email'], $code);

        $userForgot = new UserForgot($this->db);
        $userForgot->UserId = $userData['UserId'];
        $userForgot->Code = $code;
        $userForgot->forgotPassword();

        $getUserForgot = $userForgot->findByCode();
        $expireAt = $getUserForgot['ExpireAt'];

        $responseData = [
            "code" => $code,
            "expireAt" => $expireAt
        ];

        return BaseResponse::success($responseData);
    }
    
    private static function sentEmail($email, $code) {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'arygaming0407@gmail.com';
        $mail->Password = 'ngnd kspb rybs rbpz';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('no-reply@example.com', 'Maintekkenance');
        $mail->addAddress($email);
        $mail->Subject = 'Lupa Password Lagi?';
        $mail->Body = "
        Kontol,

        Anak annjj lupa password trus. Password tuh di catat!!!! ini dpe kode

        Kode: $code

        Dpe kode kedaluwarsa dalam 1 jam. Jang lupa lupa lagi!!!

        Salam,
        Tim Developer
        ";

        $mail->send();
    }
}
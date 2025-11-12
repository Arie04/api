<?php

class UserRegisterRequest {
    private $data;
    private $errors = [];

    public function __construct() {
        $this->data = json_decode(file_get_contents('php://input'), true);
    }

    public function validate() {
        if (!$this->data) {
            $this->errors[] = 'Invalid JSON body';
            return false;
        }

        if (empty($this->data['Username'])) {
            $this->errors['Username'] = 'Username is required.';
        }

        if (empty($this->data['Email'])) {
            $this->errors['Email'] = 'Email is required.';
        } 
        
        if (empty($this->data['Password'])) {
            $this->errors['Password'] = 'Password is required.';
        } 
        if (empty($this->data['ConfirmPassword'])) {
            $this->errors['ConfirmPassword'] = 'ConfirmPassword is required.';
        } 
        
        return empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getData() {
        return $this->data;
    }
}

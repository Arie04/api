<?php

class UserForgotPasswordRequest {
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

        if (empty($this->data['Email'])) {
            $this->errors['Email'] = 'Email is required.';
        } elseif (!is_string($this->data['Email'])) {
            $this->errors['Email'] = 'Email must be a string.';
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

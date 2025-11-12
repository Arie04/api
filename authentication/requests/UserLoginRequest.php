<?php

class UserLoginRequest {
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
        } elseif (!is_string($this->data['Username'])) {
            $this->errors['Username'] = 'Username must be a string.';
        }

        if (empty($this->data['Password'])) {
            $this->errors['Password'] = 'Password is required.';
        } elseif (!is_string($this->data['Password'])) {
            $this->errors['Password'] = 'Password must be a string.';
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

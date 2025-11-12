<?php

class UserResetPasswordRequest {
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
        
        if (empty($this->data['Code'])) {
            $this->errors['Code'] = 'Code is required.';
        } elseif (!is_string($this->data['Code'])) {
            $this->errors['Code'] = 'Code must be a string.';
        }

        if (empty($this->data['NewPassword'])) {
            $this->errors['NewPassword'] = 'NewPassword is required.';
        } elseif (!is_string($this->data['NewPassword'])) {
            $this->errors['NewPassword'] = 'NewPassword must be a string.';
        }

        if (empty($this->data['ConfirmPassword'])) {
            $this->errors['ConfirmPassword'] = 'ConfirmPassword is required.';
        } elseif (!is_string($this->data['ConfirmPassword'])) {
            $this->errors['ConfirmPassword'] = 'ConfirmPassword must be a string.';
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

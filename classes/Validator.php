<?php
class Validator {
    private $errors = [];
    
    public function validate($data, $rules) {
        foreach ($rules as $field => $rule) {
            if (!isset($data[$field])) {
                if ($rule['required']) {
                    $this->addError($field, "Field is required");
                }
                continue;
            }
            
            $value = $data[$field];
            
            if ($rule['required'] && empty($value)) {
                $this->addError($field, "Field is required");
            }
            
            if (isset($rule['min']) && strlen($value) < $rule['min']) {
                $this->addError($field, "Minimum length is {$rule['min']} characters");
            }
            
            if (isset($rule['email']) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $this->addError($field, "Invalid email format");
            }
            
            if (isset($rule['numeric']) && !is_numeric($value)) {
                $this->addError($field, "Must be a number");
            }
        }
        
        return empty($this->errors);
    }
    
    public function addError($field, $message) {
        $this->errors[$field] = $message;
    }
    
    public function getErrors() {
        return $this->errors;
    }
} 
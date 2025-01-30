<?php
require_once 'Validator.php';

class Property {
    private $conn;
    private $validator;
    
    public function __construct($conn) {
        $this->conn = $conn;
        $this->validator = new Validator();
    }
    
    public function validate($data) {
        $rules = [
            'title' => ['required' => true, 'min' => 3],
            'price' => ['required' => true, 'numeric' => true],
            'area' => ['required' => true, 'numeric' => true],
            'bedrooms' => ['required' => true, 'numeric' => true],
            'bathrooms' => ['required' => true, 'numeric' => true]
        ];
        
        return $this->validator->validate($data, $rules);
    }
    
    public function getErrors() {
        return $this->validator->getErrors();
    }
} 
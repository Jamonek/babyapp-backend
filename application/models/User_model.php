<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /*
    * @param string $email
    * @param string $password
    * @return array
    */
    public function signUpWithEmail($email, $password) {
        
        // Validation check
        if(empty($email) || empty($password)) {
            return array('status' => false, 'msg' => 'Missing arguments');
        }
        
        // Password length must be greater than 6 characters
        if(strlen($password) < 6) {
            return array('status' => false, 'msg' => 'Password is less than 6 characters.');
        }
        
        // Check if the email exists
        $lowerCaseEmail = trim(strtolower($email));
        $this->db->where('user_email', $lowerCaseEmail);
        $query = $this->db->get('users');
        
        if($query->num_rows() > 0) {
            // The email exists.. return
            return array('status' => false, 'msg' => 'Email exists.');
        }
        
        // Everything checks out.. Create the user 
        // But first.. generate our `rememberToken` for users
        $rememberToken = $this->generate(); // This token should be sent with all requests.. besides login/sign up
        $insertArray = array(
            'user_email'             => $lowerCaseEmail,
            'user_password'          => hash('sha256', $password),
            'remember_token'         => $rememberToken
        );
        
        if($this->db->insert('users', $insertArray)) {
            // Success
            return array('status' => true, 'msg' => 'User created', 'remember_token' => $rememberToken);
        } else {
            return array('status' => false, 'msg' => 'Error creating user');
        }
    }
    
    /**
    * @param string $email
    * @param string $password
    * @return array
    */
    public function loginWithEmail($email, $password) {
        
        // Validation check
        if(empty($email) || empty($password)) {
            return array('status' => false, 'msg' => 'Missing arguments');
        }
        
        // Check if email exists
        $lowerCaseEmail = trim(strtolower($email));
        $this->db->where('user_email', $lowerCaseEmail);
        $query = $this->db->get('users');
        
        if($query->num_rows() < 1) {
            // The email does not exist.. maybe a typo?
            return array('status' => false, 'msg' => 'Email does not exist');
        }
        
        // Everything checks out.. check if the email/password combo exist
        $hashedPassword = hash('sha256', $password);
        
        $this->db->where('user_email', $lowerCaseEmail);
        $this->db->where('user_password', $hashedPassword);
        $query = $this->db->get('users');
        
        if($query->num_rows() == 1) {
            // Success.. get the `rememberToken` and return the array
            $result = $query->result_array();
            $rememberToken = $result[0]['remember_token'];
            return array('status' => true, 'msg' => 'Login success', 'remember_token' => $rememberToken);
        } else {
            // Combo does not exist
            return array('status' => false, 'msg' => 'User not found');
        }
    }
    
    private function generate($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
?>
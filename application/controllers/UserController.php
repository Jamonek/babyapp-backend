<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function signup() {
        $type = $this->input->post('type');
        
        switch($type) {
            case "email":
                // sign up logic here
                $email      = $this->input->post('email');
                $password   = $this->input->post('password');
                
                $request    = $this->UserModel->signUpWithEmail($email, $password);
                
                $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($request));    
            break;
            case "facebook":
                $email      = $this->input->post('email');
                $facebookID = $this->input->post('fbid');
                
                $request    = $this->UserModel->signUpWithFacebook($email, $facebookID);
                
                $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($request)); 
            break;
            case "twitter": 
                $userID     = $this->input->post('twitterid');
                $authToken  = $this->input->post('twitter_auth');
                $authSecret = $this->input->post('twitter_authsecret');
                
                $request    = $this->UserModel->signUpWithTwitter($userID, $authToken, $authSecret);
                
                $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($request)); 
            break;
            default:
                // default handling
            break;    
        }
    }
    
    public function signin() {
        $type = $this->input->post('type');
        
        switch($type) {
            case "email":
                // sign in logic
                $email      = $this->input->post('email');
                $password   = $this->input->post('password');
                
                $request    = $this->UserModel->loginWithEmail($email, $password);
                
                $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($request));
            break;
            case "facebook":
                $facebookID = $this->input->post('fbid');
            break;
            default:
                // default handling
            break;
        }
    }
}
?>
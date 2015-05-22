<?php
namespace Src\Modules\Login\Models;

use Src\Lib\User\User;
use Src\Config\Config;
use Src\Lib\Data\LoginToken;
use Src\Modules\Login\Helpers\ForgotPasswordEmail;

class ForgotPasswordModel
{   
    /*
     * Store data and errors other than password
     */
    private $error = false;
    private $data = array();
    
    /*
     * Store user data
     */
    private $user_data = array();
    
    /*
     * Store login token
     */
    private $login_token;
    
    /*
     * Store PDO
     */
    private $pdo;
    
    /*
     * Set PDO
     */
    public function setPDO( \PDO $pdo )
    {
        $this->pdo = $pdo;
    }

    /*
     * Return data
     */
    public function getData()
    {
        return $this->data;
    }
    
    /*
     * Run the log in process
     */
    public function run()
    {
        // Make sure the user isn't logged in;
        $this->redirectIfLoggedIn();
        
        // Check if this is the success page
        if ( $this->success() ) {
            return;
        }
        
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $this->processRequest();
        }
    }
    
    /*
     * Redirect the user to the profile page if already logged in
     */
    private function redirectIfLoggedIn()
    {
        $user = User::getInstance();
        if ( $user->isSignedIn() ) {
            $this->redirect('/profile');
        }
    }
    
    /*
     * Check if this is the success page
     */
    private function success()
    {
        if ( isset( $_GET['action'] ) && $_GET['action'] == 'success' ) {
            $this->data['success'] = true;
            return true;
        }
        return false;
    }
    
    /*
     * Attempt to process the request
     */
    private function processRequest()
    {
        if ( ! $this->setUsername() ) {
            return;
        }
        
        $this->lookUpUser();
        
        if ( isset( $this->user_data['email'] ) ) {
            $this->createLoginToken();
            $this->sendForgotPasswordEmail();
        }
        
        $this->redirect('/forgotpassword/success');
    }
    
    /*
     * Look for the username or email submission
     */
    private function setUsername()
    {
        if ( ! isset( $_POST['username'] ) ) {
            return;
        }
        
        $u = trim( $_POST['username'] );
        
        if ( $u == null ) {
            $this->error = true;
            $this->data['error']['username'] = 'Please enter your username or email.';
            return false;
        }
        
        $this->data['username'] = $u;
        return true;
    }
    
    /*
     * Look up the user
     */
    private function lookUpUser()
    {
        if ( isset( $this->data['username'] ) && $this->pdo ) {
            
            $q = 'SELECT * FROM users WHERE username=:username OR email=:email LIMIT 1';
            
            $stmt = $this->pdo->prepare($q);
            $stmt->bindParam(':username', $this->data['username']);
            $stmt->bindParam(':email', $this->data['username']);
            
            if ( $stmt->execute() ) {
                $r = $stmt->fetch(\PDO::FETCH_ASSOC);
            }
            if ( $r ) {
                foreach ( $r as $k => $v ) {
                    $this->user_data[$k] = $v;
                }
            }
            return true;
        }
        $this->error = true;
        $this->data['error']['form'] = 'An error occurred. Please try again.';
        return false;
    }
    
    /*
     * Create the login token
     */
    private function createLoginToken()
    {
        $this->login_token = new LoginToken;
        $this->login_token->setPDO( $this->pdo );
        $this->login_token->setUserId( $this->user_data['id'] );
        $this->login_token->generate();
    }
    
    /*
     * Send the email
     */
    private function sendForgotPasswordEmail()
    {
        $config = Config::getInstance();
        
        $email = new ForgotPasswordEmail;
        $email->setToken( $this->login_token->getValue() );
        $email->setUrl( $config->get('url') );
        $email->setFrom( $config->get('siteemail') );
        $email->setTo( $this->user_data['email'] );
        $email->setSubject();
        $email->setBody();
        
        $email->send();
    }
    
    /*
     * Redirect
     */
    private function redirect( $url )
    {
        header('Location: ' . $url);
        exit;
    }
}

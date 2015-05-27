<?php
namespace Src\Modules\Login\Models;

use Src\Includes\SuperClasses\Model;
use Src\Includes\Database\DB;
use Src\Includes\Session\Session;
use Src\Includes\User\User;
use Src\Includes\Data\LoginToken;
use Src\Includes\Data\Password;

class ResetPasswordModel extends Model
{
    /*
     * Store the submitted passwords
     */
    private $new_pass;
    private $confirm_pass;
    
    /*
     * Store the login token and email
     */
    private $url_token = null;
    private $url_email = null;
    
    /*
     * Store the token object
     */
    private $token;
    
    /*
     * Store data, error status
     */
    private $error = false;
    
    /*
     * Store user data
     */
    private $user_data = array();
    
    /*
     * Run
     */
    public function run()
    {
        // Test for success
        if ( $this->success() ) {
            return;
        }
        
        // Test for email and login token
        if ( ! $this->validateToken() ) {
            $this->data['status'] = 'INVALID';
            return;
        }
        
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $this->resetPassword();
        }
    }
    
    /*
     * Test for success
     */
    private function success()
    {
        if ( ! isset($this->request['action'] ) || $this->request['action'] != 'success' ) {
            return false;
        }

        $user = User::getInstance();
        
        if ( ! $user->isSignedIn() ) {
            return false;
        }
        
        $this->data['status'] = 'SUCCESS';
        return true;
    }
    
    /*
     * Validate the token and email
     */
    private function validateToken()
    {
        if ( ! $this->setEmail() || ! $this->setToken() ) {
            return false;
        }

        if ( ! $this->lookUpUser() ) {
            return false;
        }
        
        $this->token = new LoginToken;
        $valid = $this->token->verify( $this->user_data['id'], $this->url_token );
        
        if ( ! $valid ) {
            return false;
        }
        
        $this->data['status'] = 'VALID';
        return true;
    }
    
    /*
     * Set the email
     */
    private function setEmail()
    {
        if ( ! isset( $this->request['e'] ) ) {
            return false;
        }
        
        $e = trim( urldecode( $this->request['e'] ) );
        
        if ( ! filter_var( $e, FILTER_VALIDATE_EMAIL ) ) {
            return false;
        }

        $this->url_email = $e;
        return true;
    }
    
    /*
     * Set the token
     */
    private function setToken()
    {
        if ( ! isset( $this->request['t'] ) ) {
            return false;
        }
        
        $t = trim( urldecode( $this->request['t'] ) );

        if ( $t == null ) {
            return false;
        }
        
        $this->url_token = $t;
        return true;
    }
    
    /*
     * Look up the user by email
     */
    protected function lookUpUser()
    {
        if ( ! $this->url_email ) {
            return false;
        }
        
        $pdo = DB::getInstance();
        
        $q = "SELECT * FROM users WHERE email=:email";
        
        $stmt = $pdo->prepare($q);
        $stmt->bindParam(':email', $this->url_email);
        
        if ( $stmt->execute() ) {
            $r = $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        if ( $r ) {
            foreach( $r as $k => $v ) {
                $this->user_data[$k] = $v;
            }
            return true;
        }
        return false;
    }   
         
    /*
     * Attempt to reset the password
     */
    private function resetPassword()
    {   
        if ( ! $this->setPasswords() ) {
            return false;
        }
        
        // Everything is good. Remove the token, sign in and redirect to success
        $this->signInUser();
        
        if ( ! $this->updatePassword() ) {
            $error = true;
            $this->data['error']['form'] = 'An error occurred while updating your password. Please try again.';
            return false;
        }

        $this->token->delete();
        
        $this->redirect('resetpassword/success');
    }
    
    /*
     * Set passwords
     */
    private function setPasswords()
    {
        if ( ! isset( $_POST['new_pass'] ) || ! isset( $_POST['confirm_pass'] ) ) {
            return false;
        }
        
        $this->new_pass = new Password( $_POST['new_pass'] );
        $this->confirm_pass = new Password( $_POST['confirm_pass'] );
        
        if ( ! $this->new_pass->isValid() ) {
            $this->error = true;
            $this->data['error']['new_pass'] = $this->new_pass->getError();
            return false;
        }
        
        if ( $this->new_pass->getValue() != $this->confirm_pass->getValue() ) {
            $this->error = true;
            $this->data['error']['confirm_pass'] = "Your confirmed password did not match. Please try again.";
            return false;
        }
        
        return true;
    }
    
    /*
     * Update the users password
     */
    private function updatePassword()
    {
        $user = User::getInstance();
        $user->set('id', $this->user_data['id'] );
        $user->read();
        
        $user->set('pass', $this->new_pass->getHashed() );
        return $user->update();
    }
    
    /*
     * Sign in the user
     */
    protected function signInUser()
    {
        $session = Session::getInstance();
        $session->regenerate();
        $session->set('user_id', $this->user_data['id'] );
    }
}

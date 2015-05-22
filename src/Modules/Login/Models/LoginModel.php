<?php
namespace Src\Modules\Login\Models;

use Src\Lib\User\User;
use Src\Lib\Session\Session;
use Src\Lib\Data\Username;
use Src\Lib\Data\Email;
use Src\Lib\Data\Password;

/*
 * Attempts to log a user in.
 */
class LoginModel
{
    /*
     * Password, user data from the DB
     */
    private $password = null;
    private $user_data = array();
    
    /*
     * Store data and errors other than password
     */
    private $error = false;
    private $data = array();
    
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
        
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $this->attemptLogin();
        }
    }
    
    /*
     * Redirect the user to the profile page if already logged in
     */
    private function redirectIfLoggedIn()
    {
        $user = User::getInstance();
        if ( $user->isSignedIn() ) {
            $this->redirect();
        }
    }
    
    /*
     * Attempt login
     */
    private function attemptLogin()
    {
        $this->setUsername();
        $this->setPassword();
        
        if ( $this->error ) {
            return;
        }
        
        if ( $this->lookUpUser() && $this->validatePassword() ) {
            $this->signInUser();
            $this->redirect();
        }
    }
    
    /*
     * Set the username or email
     */
    private function setUsername()
    {
        if ( ! isset($_POST['username'] ) ) {
            return false;
        }
        
        $value = trim( $_POST['username'] );
        
        $this->data['username'] = filter_var( $value, FILTER_SANITIZE_SPECIAL_CHARS );
        
        if ( $value == null ) {
            $this->error = true;
            $this->data['error']['username'] = 'Please enter your username or email.';
            return false;
        }
        
        return true;
    }
    
    /*
     * Set the password
     */
    private function setPassword()
    {
        if ( ! isset( $_POST['pass'] ) ) {
            return false;
        }
        
        $value = trim( $_POST['pass'] );

        $this->password = $value;
        
        if ( $_POST['pass'] == null ) {
            $this->error = true;
            $this->data['error']['password'] = 'Please enter your password.';
            return false;
        }
        
        return true;
    }
    
    /*
     * Look up the user
     */
    private function lookUpUser()
    {
        if ( isset( $this->data['username'] ) && $this->password && $this->pdo ) {
            
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
                return true;
            } else {
                $this->error = true;
                $this->data['error']['form'] = 'The username and password did not match those on file. Please try again.';
                return false;
            }
        }
        $this->error = true;
        $this->data['error']['form'] = 'An error occurred. Please try again.';
        return false;
    }
    
    /*
     * Validate the password
     */
    private function validatePassword()
    {
        if (
            $this->password
            && $this->user_data['pass']
            && password_verify( $this->password, $this->user_data['pass'] )
        ) {
            return true;
        }
        
        $this->error = true;
        $this->data['error']['form'] = 'The username and password did not match those on file. Please try again.';
        return false;
    }
    
    /*
     * Sign in the user
     */
    private function signInUser()
    {
        $session = Session::getInstance();
        $session->regenerate();
        $session->set('user_id', $this->user_data['id'] );
    }
    
    /*
     * Redirect on success
     */
    private function redirect()
    {
        header('Location: /profile');
        exit;
    }
}

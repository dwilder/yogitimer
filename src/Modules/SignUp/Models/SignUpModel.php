<?php
namespace Src\Modules\SignUp\Models;

use Src\Lib\Data\Username;
use Src\Lib\Data\Email;
use Src\Lib\Data\Password;
use Src\Lib\Data\ActivationKey;
use Src\Lib\Data\Roles;
use Src\Lib\User\User;
use Src\Lib\User\UserRoles;
use Src\Lib\Session\Session;
use Src\Config\Config;
use Src\Modules\SignUp\Helpers\VerificationEmail;

/*
 * On failure:
 * - pass the username, email and errors back to the view
 *
 * On success:
 * - hash the password
 * - add the user to the database
 * - log in the user
 * - send a registration email
 * - redirect to /signup/complete
 */

class SignUpModel
{
	/*
	 * Store PDO
	 */
	private $pdo;
	
	/*
	 * Store the Username, Email, Password, ActivationKey objects
	 */
	private $username;
	private $email;
	private $password;
	private $activation_key;
	
	/*
	 * Store the username, email, password, and errors
	 */
	private $data = array();
	private $error = false;
    
    /*
     * Store the new user id
     */
    private $user_id;
	
	public function setPDO( \PDO $pdo )
	{
		$this->pdo = $pdo;
	}
	
	/*
	 * Run the necessary functions
	 */
	public function run()
	{
        // Make sure the user isn't logged in
        $this->isUserLoggedIn();
        
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
			$this->registerUser();
			return;
		}
	}
    
    /*
     * Test if the user is logged in
     */
    private function isUserLoggedIn()
    {
        $user = User::getInstance();
        if ( $user->isSignedIn() ) {
            header( 'Location: /profile' );
            exit;
        }
    }
	
	/*
	 * Attempt to register a new user
	 */
	private function registerUser()
	{
		$this->setData();
		
		if ( $this->error ) {
			return;
		}
		
		if ( ! $this->createUser() || ! $this->addUserRole() ) {
			return;
		}

		$this->setSessionData();
		$this->sendVerificationEmail();
		$this->redirect();
	}
	
	/*
	 * Set the data
	 */
	private function setData()
	{
		$this->setUsername();
		$this->setEmail();
		$this->setPassword();
        $this->setActivationKey();
	}
	
	/*
	 * Return stored data. NOT password
	 */
	public function getData()
	{	
		return $this->data;
	}
	
	/*
	 * Set the username value
	 */
	private function setUsername()
	{
		$u = null;
		if ( isset( $_POST['username'] ) ) {
			$u = strtolower( filter_input( INPUT_POST, 'username', FILTER_SANITIZE_STRING ) );
		}
		
		$this->username = new Username( $u );
		$this->username->setPDO( $this->pdo );
		
		if ( ! $this->username->test() ) {
			$this->error = true;
			$this->data['error']['username'] = $this->username->getError();
		}

		$this->data['username'] = $this->username->getValue();
	}
	
	/*
	 * Set the email value
	 */
	private function setEmail()
	{
		$e = null;
		if ( isset( $_POST['email'] ) ) {
			$e = strtolower( filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL ) );
		}
		
		$this->email = new Email( $e );
		$this->email->setPDO( $this->pdo );
		
		if ( !$this->email->test() ) {
			$this->error = true;
			$this->data['error']['email'] = $this->email->getError();
		}
		
		$this->data['email'] = $this->email->getValue();
	}
	
	/*
	 * Set the password
	 */
	private function setPassword()
	{
		$p = null;
		if ( isset( $_POST['pass'] ) ) {
			$p = $_POST['pass'];
		}
		
		$this->password = new Password( $p );
		
		if ( !$this->password->test() ) {
			$this->error = true;
			$this->data['error']['password'] = $this->password->getError();
		}
	}
	
    /*
     * Set the activation key
     */
    private function setActivationKey()
    {
		$this->activation_key = new ActivationKey;
		$k = $this->activation_key->set();
    }
    
	/*
	 * Add the user to the database
	 */
	private function createUser()
	{
		
		$u = $this->username->getValue();
		$e = $this->email->getValue();
		$p = password_hash( $this->password->getValue(), PASSWORD_DEFAULT );
		$k = $this->activation_key->get();
		$s = $this->getUserStatus();
		
		// Build the query
		$q = 'INSERT INTO users (
			username,
			email,
			registered_email,
			pass,
			activation_key,
			status,
			date_added
		) VALUES (
			:username,
			:email,
			:registered_email,
			:pass,
			:activation_key,
			:status,
			UTC_TIMESTAMP()
		)';
	
		$stmt = $this->pdo->prepare($q);
		
		$stmt->bindValue(':username', $u, \PDO::PARAM_STR);
		$stmt->bindValue(':email', $e, \PDO::PARAM_STR);
		$stmt->bindValue(':registered_email', $e, \PDO::PARAM_STR);
		$stmt->bindValue(':pass', $p, \PDO::PARAM_STR);
		$stmt->bindValue(':activation_key', $k, \PDO::PARAM_STR);
		$stmt->bindValue(':status', $s, \PDO::PARAM_INT);
		
		// Check for success and get the ID
		if ( $stmt->execute() ) {
			$this->user_id = $this->pdo->lastInsertId();
            return true;
		} else {
			$this->error = true;
			$this->data['error']['form'] = 'An error occurred and your account couldn\'t be created. Please try again.';
			return false;
		}
		
	}
    
    /*
     * Add the user role to the database
     */
    private function addUserRole()
    {
        $roles = new Roles;
        $newUserRole = $roles->getNewUserRole();
        
        $user_roles = new UserRoles;
        $user_roles->setPDO( $this->pdo );
        $user_roles->setUserId( $this->user_id );
        $user_roles->addRole( $newUserRole );
        
        if ( ! $user_roles->create() ) {
			$this->error = true;
			$this->data['error']['form'] = "An error occurred while creating your account. You can access most functionality, but some glitches may occur.";
            return false;
        }
        
        return true;
    }
	
	/*
	 * Get the user status value
	 */
	private function getUserStatus()
	{
		return 0;
	}
    
    /*
     * Set session data to log the user in
     */
    private function setSessionData()
    {
        $session = Session::getInstance();
		// Regenerate the session
        $session->regenerate();
        // Add the user id to the session
        $session->set( 'user_id', $this->user_id );
    }
    
    /*
     * Send a verification email
     */
    private function sendVerificationEmail()
    {
        $config = Config::getInstance();
        $email = new VerificationEmail;
        
        $email->setTo( $this->email->getValue() );
        $email->setFrom( $config->get( 'siteemail' ) );
        $email->setSubject();
        $email->setUrl( $config->get( 'url' ) );
        $email->setKey( $this->activation_key->get() );
        $email->setBody();
        
        $email->send();
    }
    
    /*
     * Redirect to the completion page
     */
    private function redirect()
    {
        header('Location: /signup/success');
        exit();
    }
}
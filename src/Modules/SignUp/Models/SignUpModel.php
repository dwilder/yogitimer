<?php
namespace Src\Modules\SignUp\Models;

use Src\Includes\SuperClasses\Model;
use Src\Config\Config;
use Src\Includes\Database\DB;
use Src\Includes\Session\Session;
use Src\Includes\User\User;
use Src\Includes\Data\Username;
use Src\Includes\Data\Email;
use Src\Includes\Data\Password;
use Src\Includes\Data\ActivationKey;
use Src\Includes\Data\Roles;
use Src\Includes\Data\UserDirectory;
use Src\Includes\User\UserRoles;
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

class SignUpModel extends Model
{
	/*
	 * Store the Username, Email, Password, ActivationKey objects
	 */
    private $user;
	private $username;
	private $email;
	private $password;
	private $activation_key;
	private $user_directory;
	
	/*
	 * Store the username, email, password, and errors
	 */
	protected $error = false;
    
    /*
     * Store the new user id
     */
    private $user_id;
	
	/*
	 * Run the necessary functions
	 */
	public function run()
	{
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
			$this->registerUser();
			return;
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
		$this->redirect('signup/success');
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
	 * Set the username value
	 */
	private function setUsername()
	{
		$u = null;
		if ( isset( $_POST['username'] ) ) {
			$u = strtolower( filter_input( INPUT_POST, 'username', FILTER_SANITIZE_STRING ) );
		}
		
		$this->username = new Username( $u );
		
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
		
		if ( ! $this->email->test() ) {
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
		
		if ( ! $this->password->test() ) {
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
		$this->activation_key->set();
    }
    
    
	/*
	 * Add the user to the database
	 */
	private function createUser()
	{
        $this->createUploadDirectory();
        
		$this->user = User::getInstance();
        
		$this->user->set( 'username', $this->username->getValue() );
		$this->user->set( 'email', $this->email->getValue() );
		$this->user->set( 'pass', password_hash( $this->password->getValue(), PASSWORD_DEFAULT ) );
		$this->user->set( 'activation_key', $this->activation_key->get() );
		$this->user->set( 'status', $this->getUserStatus() );
		$this->user->set( 'directory', $this->user_directory->get() );
		
		// Check for success and get the ID
		if ( $this->user->create() ) {
            return true;
		} else {
			$this->error = true;
			$this->data['error']['form'] = 'An error occurred and your account couldn\'t be created. Please try again.';
			return false;
		}
		
	}
    
    /*
     * Create an upload directory for the user
     */
    private function createUploadDirectory()
    {
        $this->user_directory = new UserDirectory;
        $this->user_directory->create();
    }
    
    /*
     * Add the user role to the database
     */
    private function addUserRole()
    {
        $roles = new Roles;
        $newUserRole = $roles->getNewUserRole();
        
        $user_roles = new UserRoles;
        $user_roles->setUserId( $this->user->get('id') );
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
        $session->set( 'user_id', $this->user->get('id') );
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
}
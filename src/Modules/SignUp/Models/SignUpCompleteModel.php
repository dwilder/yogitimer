<?php
namespace Src\Modules\SignUp\Models;

use Src\Lib\User\User;
use Src\Lib\Session\Session;

/*
 * - make sure the user has successfully signed up
 * - make sure the user is logged in
 * - make sure the user account activation key is not null
 *
 */

class SignUpCompleteModel
{
	/*
	 * Store a reference to objects
	 */
	private $pdo;
	
	/*
	 * Store the username
	 */
	private $data = array();
	
	/*
	 * Set objects
	 */
	public function setPDO( \PDO $pdo )
	{
		$this->pdo = $pdo;
	}
	
	/*
	 * Run the necessary functions
	 */
	public function run()
	{
        $this->verifyUserIsSignedIn();
		$this->verifyUserIsNew();
	}
	
	/*
	 * Return stored data. NOT password
	 */
	public function getData()
	{	
		return $this->data;
	}
    
    /*
     * Make sure the user has just signed up
     */
    private function verifyUserIsNew()
    {
        $user = User::getInstance();
        
        // Check if the user still has an activation key
        if ( ! $user->isActive() ) {
            // Send to the log in page
            //header( 'Location: /login' );
            exit('not active');
        }
    }
    
    /*
     * Make sure the user is signed in
     */
    private function verifyUserIsSignedIn()
    {
        $user = User::getInstance();
        
        if ( ! $user->isSignedIn() ) {
            // Send to the sign up page
            //header( 'Location: /signup' );
            exit('not signed in');
        }
    }
}
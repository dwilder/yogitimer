<?php
namespace Src\Modules\SignUp\Models;

use Src\Includes\SuperClasses\Model;
use Src\Includes\User\User;
use Src\Includes\Session\Session;

/*
 * - make sure the user has successfully signed up
 * - make sure the user is logged in
 * - make sure the user account activation key is not null
 *
 */

class SignUpCompleteModel extends Model
{
	/*
	 * Run the necessary functions
	 */
	public function run()
	{
        $this->verifyUserIsSignedIn();
		$this->verifyUserIsNew();
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
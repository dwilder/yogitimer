<?php
namespace Src\Modules\SignUp;

use Src\Includes\SuperClasses\UIController;
use Src\Includes\User\User;

/*
 * Controller class for signing up.
 *
 * - Sign Up			/signup
 * - Sign Up Thank You	/signup/success
 * - Activation			/activate/[email]/[token]
 */

class Controller extends UIController
{
    /*
     * A method to get the class
     */
    protected function setClass()
    {
		switch( $this->request['guid'] ) {
			case 'activate':
				$class = 'Activation';
				break;
			case 'signup':
			default:
				if ( isset( $this->request['action'] ) && $this->request['action'] == 'success' ) {
					$class = 'SignUpComplete';
                    $this->checkLoginStatus('authenticated');
				} else {
					$class = 'SignUp';
                    $this->checkLoginStatus('anonymous');
				}
				break;
		}
        $this->class = $class;
    }
    
    /*
     * Manage redirection
     */
    protected function checkLoginStatus( $login_access = 'anonymous' )
    {
        $user = User::getInstance();
        
        if ( $login_access == 'anonymous' && $user->isSignedIn() ) {
            $this->redirect('profile');
            return;
        }
        if ( $login_access == 'authenticated' && ! $user->isSignedIn() ) {
            $this->redirect('login');
            return;
        }
    }
}
<?php
namespace Src\Modules\Logout;

use Src\Includes\SuperClasses\AbstractController;
use Src\Includes\User\User;
use Src\Includes\Session\Session;

/*
 * Controller class for logging out.
 */

class Controller extends AbstractController
{
    /*
     * Run the program
     */
    public function run()
    {
        $this->logout();
    }

    /*
     * Log out the current user
     */
    public function logout()
    {
        $user = User::getInstance();
        
        if ( $user->isSignedIn() ) {
            $this->destroySession();
        }
        
        $this->redirect('login');
    }
    
    /*
     * Destroy the session
     */
    protected function destroySession()
    {
        $session = Session::getInstance();
        $session->destroy();
    }
}
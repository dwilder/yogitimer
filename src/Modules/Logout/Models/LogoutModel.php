<?php
namespace Src\Modules\Logout\Models;

use Src\Lib\User\User;
use Src\Lib\Session\Session;

class LogoutModel
{
    /*
     * Log out the current user
     */
    public function logout()
    {
        $user = User::getInstance();
        
        if ( $user->isSignedIn() ) {
            $this->destroySession();
        }
        
        $this->redirect();
    }
    
    /*
     * Destroy the session
     */
    protected function destroySession()
    {
        $session = Session::getInstance();
        $session->destroy();
    }
    
    /*
     * Redirect to login
     */
    protected function redirect()
    {
        header( 'Location: /login' );
        exit;
    }
}

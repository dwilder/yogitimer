<?php
namespace Src\App;

use Src\Includes\User\User;
/*
 * Test for authentication - redirect to login
 * Test for SSL - redirect to HTTP / HTTPS as needed
 */


class SecurityLayer
{
    /*
     * Store the authentication
     */
    private $login_access;
    
    /*
     * Set the login access for the module
     */
    public function setLoginAccess( $access ) {
        $this->login_access = $access;
    }
    
    /*
     * Run
     */
    public function run()
    {
        $this->testAuthentication();
    }
    
    /*
     * Test for authentication
     */
    private function testAuthentication()
    {
        if ( $this->login_access == 'all' ) {
            return;
        }
        
        $user = User::getInstance();
        
        if ( $this->login_access == 'authenticated' && ! $user->isSignedIn() ) {
            $this->redirect('login');
        }
        
        if ( $this->login_access == 'anonymous' && $user->isSignedIn() ) {
            $this->redirect('profile');
        }
    }
    
    /*
     * Redirect
     */
    protected function redirect( $url, $secure )
    {
        $location = '/' . $url;
        
        header('Location: ' . $location);
        exit;
    }
}

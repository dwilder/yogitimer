<?php
namespace Src\Modules\SignUp\Models;

use Src\Includes\SuperClasses\Model;
use Src\Includes\Database\DB;
use Src\Includes\User\User;
use Src\Includes\Session\Session;
/*
 * - Test if user is logged in
 * - Check for email address and activation key /
 * - Look up registered email address, return activation key and user id /
 * - If email is not found in DB, display ERROR /
 *
 * - If key is null AND user is logged in AND user ids match, display "Already active" page with link to profile /
 * - If key is null AND user is NOT logged in, display ERROR /
 *
 * - If key is NOT null AND user is logged in AND user id does NOT match - ERROR /
 * - If key is NOT null AND user is logged in AND user id matches - OK /
 * - If key is NOT null AND user is NOT logged in - OK /
 *
 * - If keys match, null activation key
 *      - If user is NOT logged in, log in user
 *      - regenerate the session
 */

class ActivationModel extends Model
{
    /*
     * Store activation key and email address from the url
     */
    private $url_email = null;
    private $url_activation_key = null;
    
    /*
     * Store the activation key and user data from the database
     */
    private $user_data = array();
    
    /*
     * Track errors
     */
    private $error = false;
    
    /*
     * Run
     */
    public function run()
    {
        // Need the current user
        $user = User::getInstance();
        
        // Make sure the necessary info is supplied in the activation url
        if ( ! $this->setUrlEmail() || ! $this->setUrlActivationKey() ) {
            return;
        }
        
        // Look up the user based on registered email
        if ( ! $this->lookUpUser() ) {
            return;
        }
        
        // Check if the account is already active
        if ( $this->isAccountActive() ) {
            if ( ! $user->isSignedIn() ) {
                $this->error = true;
                $this->data['error'] = 'VOID';
                return;
            }
            // Verify the activation link is for the current user
            if ( $this->verifySignedInUser() ) {
                $this->error = true;
                $this->data['error'] = 'ACTIVE ACCOUNT';
                return;
            }
            return;
        } // Account is not active

        // If the user is already logged in, make sure the current user matches the activation
        if ( ! $this->verifySignedInUser() ) {
            return;
        }
        
        // Verify the keys
        if ( ! $this->verifyActivationKey() ) {
            return;
        }
        
        // Activate the account
        if ( $this->activateAccount() ) {
            $this->signInUser( $user->get('id') );
            $this->data['success'] = true;
        }
        
    }
    
    /*
     * Get the email address from the url
     */
    private function setUrlEmail()
    {
        $email = null;
        if ( ! isset($this->request['e'] ) ) {
            $this->error = true;
            $this->data['error'] = 'NO EMAIL';
            return false;
        }
        
        $email = urldecode( $this->request['e'] );
        
        if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
            $this->error = true;
            $this->data['error'] = 'INVALID EMAIL';
            return false;
        }
        
        $this->url_email = $email;
        return true;
    }
    
    /*
     * Get the activation key from the url
     */
    private function setUrlActivationKey()
    {
        $key = null;
        if ( ! isset( $this->request['k'] ) ) {
            $this->error = true;
            $this->data['error'] = 'NO KEY';
            return false;
        }
        
        if ( ! preg_match( '/^([a-zA-Z0-9]{1,})$/', $this->request['k'] ) ) {
            $this->error = true;
            $this->data['error'] = 'INVALID KEY';
            return false;
        }
        
        $this->url_activation_key = preg_replace( '/[^a-zA-Z0-9]/', '', $_GET['k'] );
        return true;
    }
    
    /*
     * Look up the user based on the email address in the url
     */
    private function lookUpUser()
    {
        if ( $this->url_email ) {
            
            $pdo = DB::getInstance();
            
            $q = "SELECT * FROM users WHERE registered_email=:registered_email";
            
            $stmt = $pdo->prepare($q);
            $stmt->bindParam( ':registered_email', $this->url_email );
            
            if ( ! $stmt->execute() ) {
                $this->error = true;
                $this->data['error'] = 'USER NOT FOUND';
                return false;
            }
            
            $this->user_data = $stmt->fetch(\PDO::FETCH_ASSOC);
            return true;
        }
    }
    
    /*
     * Check if the activation key is null (account is active)
     */
    private function isAccountActive()
    {
        if ( $this->user_data['activation_key'] == null ) {
            return true;
        }
        return false;
    }
    
    /*
     * Verify that the account is not already active and that the keys match
     */
    private function verifyActivationKey()
    {
        if ( $this->user_data['activation_key'] != $this->url_activation_key ) {
            $this->error = true;
            $this->data['error'] = 'MISMATCHED KEYS';
            return false;
        }
        return true;
    }
    
    /*
     * Check for a signed in user and make sure the current user and the activation match
     */
    private function verifySignedInUser()
    {
        $user = User::getInstance();
        
        if ( ! $user->isSignedIn() ) {
            return true;
        }
        
        $user_id = $user->get('id');
        if ( $user_id == $this->user_data['id'] ) {
            return true;
        }
        
        $this->error = true;
        $this->data['error'] = 'MISMATCHED USER';
        return false;
    }
    
    /*
     * Activate the account
     */
    private function activateAccount()
    {
        if ( isset( $this->user_data['id'] ) ) {
            
            $pdo = DB::getInstance();
            
            $q = "UPDATE users SET activation_key=null WHERE id=:id LIMIT 1;";
            
            $stmt = $pdo->prepare($q);
            $stmt->bindParam(':id', $this->user_data['id']);
            
            if ( $stmt->execute() ) {
                return true;
            }
            
            // Didn't work
            $this->error = true;
            $thid->data['error'] = 'DATABASE FAILURE';
            return false;
        }
    }
    
    /*
     * Set session data to log the user in
     */
    private function signInUser( $user_id )
    {
        $session = Session::getInstance();
        $session->regenerate();
        $session->set( 'user_id', $user_id );
    }
}
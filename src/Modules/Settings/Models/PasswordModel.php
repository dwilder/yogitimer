<?php
namespace Src\Modules\Settings\Models;

use Src\Includes\SuperClasses\Model;
use Src\Includes\Form\Form;
use Src\Includes\User\User;
use Src\Includes\Data\Password;

class PasswordModel extends Model
{	
    /*
     * Store the passwords
     */
    private $pass;
    private $new_pass;
    private $confirm_pass;
    
	/*
	 * Run
	 */
	public function run()
	{
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
		    $this->processRequest();
		}
	}
    
    /*
     * Process the form submission
     */
    protected function processRequest()
    {
        if ( ! $this->validatePassword() ) {
            return;
        }
        
        if ( ! $this->setPasswords() ) {
            return;
        }
        
        if ( ! $this->updatePassword() ) {
            return;
        }
        
        $this->data['success'] = true;
    }
    
    
    /*
     * Validate the original password
     */
    private function validatePassword()
    {
        if ( ! isset( $_POST['pass' ] ) ) {
            return false;
        }
        
        $this->pass = trim( $_POST['pass'] );
        
        $user = User::getInstance();
        
        if ( password_verify( $this->pass, $user->get('pass') ) ) {
            return true;
        }
        
        $this->error = true;
        $this->data['error']['pass'] = 'The password is incorrect. Please try again.';
        return false;
    }
    
    /*
     * Set passwords
     */
    private function setPasswords()
    {
        if ( ! isset( $_POST['new_pass'], $_POST['confirm_pass'] ) ) {
            return false;
        }
        
        $this->new_pass = new Password( trim( $_POST['new_pass'] ) );
        $this->confirm_pass = new Password( trim( $_POST['confirm_pass'] ) );
        
        if ( ! $this->new_pass->isValid() ) {
            $this->error = true;
            $this->data['error']['new_pass'] = $this->new_pass->getError();
            return false;
        }
        
        if ( $this->new_pass->getValue() != $this->confirm_pass->getValue() ) {
            $this->error = true;
            $this->data['error']['confirm_pass'] = "Your confirmed password did not match. Please try again.";
            return false;
        }
        
        return true;
    }
    
    
    /*
     * Update the users password
     */
    private function updatePassword()
    {
        $user = User::getInstance();
        $user->set('pass', $this->new_pass->getHashed() );
        return $user->update();
    }
}
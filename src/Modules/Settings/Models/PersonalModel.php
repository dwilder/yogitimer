<?php
namespace Src\Modules\Settings\Models;

use Src\Includes\SuperClasses\Model;
use Src\Includes\User\User;
use Src\Includes\Data\Username;
use Src\Includes\Data\Email;

class PersonalModel extends Model
{	
    /*
     * Store username and email objects
     */
    private $username;
    private $email;
    
    /*
     * Store error
     */
    protected $error = false;
    
	/*
	 * Set the data
	 */
	public function run()
	{
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $this->processRequest();
        }
        
        $this->setUserData();
	}
    
    /*
     * Process the submission
     */
    protected function processRequest()
    {
        $user = User::getInstance();
        
        $this->setSubmittedValue( new Username, 'username' );
        $this->setSubmittedValue( new Email, 'email' );
        
        if ( $user->update() ) {
            $this->data['success'] = true;
        }
    }
    
    /*
     * Set the username
     */
    private function setSubmittedValue( $object, $name )
    {
        $this->$name = $object;
        
        if ( ! isset( $_POST[$name] ) ) {
            return false;
        }
        
        $this->$name->setValue( $_POST[$name] );
        
        $user = User::getInstance();
        
        if ( $user->get($name) == $this->$name->getValue() ) {
            return true;
        }
        
        if ( ! $this->$name->test() ) {
            $this->error = true;
            $this->data['error'][$name] = $this->$name->getError();
            return false;
        }
        
        $user->set($name, $this->$name->getValue() );

        return true;
    }
    
    /*
     * Set the User data in the data array
     */
    protected function setUserData()
    {
        $user = User::getInstance();

        $this->data['username'] = $user->get('username');
        $this->data['email'] = $user->get('email');
    }
}
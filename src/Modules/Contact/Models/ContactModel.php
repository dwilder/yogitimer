<?php
namespace Src\Modules\Contact\Models;

use Src\Includes\SuperClasses\Model;
use Src\Config\Config;
use Src\Modules\Contact\Helpers\ContactEmail;

class ContactModel extends Model
{
    /*
     * Values
     */
    protected $name;
    protected $email;
    protected $message;
    
    /*
     * Error marker
     */
    protected $error = false;
    
    /*
     * Run
     */
    public function run()
    {
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $this->process();
        }
    }
    
    /*
     * Set values
     */
    protected function process()
    {
        $this->setName();
        $this->setEmail();
        $this->setMessage();
        
        if ( $this->error ) {
            return;
        }
        
        if ( $this->sendContactEmail() ) {
            $this->data['name'] = '';
            $this->data['email'] = '';
            $this->data['message'] = '';
            $this->data['success'] = true;
        } else {
            $this->data['error']['form'] = "An error occurred. Your message could not be sent.";
        }
    }
    
    /*
     * Set the name
     */
    protected function setName()
    {
        if ( ! isset( $_POST['name'] ) ) {
            $this->error = true;
            $this->data['error']['name'] = 'Please provide your name.';
            return;
        }
        
        $this->name = strip_tags( trim( $_POST['name'] ) );
        
        if ( $this->name == '' ) {
            $this->error = true;
            $this->data['error']['name'] = 'Please provide your name.';
            return;
        }
        
        $this->data['name'] = htmlspecialchars( $this->name );
    }
    
    /*
     * Set the email
     */
    protected function setEmail()
    {
        if ( ! isset( $_POST['email'] ) ) {
            $this->error = true;
            $this->data['error']['email'] = 'Please provide your email address.';
            return;
        }
        
        $this->email = strip_tags( trim( $_POST['email'] ) );
        
        if ( ! filter_var( $this->email, FILTER_VALIDATE_EMAIL ) ) {
            $this->error = true;
            $this->data['error']['email'] = 'Please provide a valid email address.';
            return;
        }
        
        $this->data['email'] = htmlspecialchars( $this->email );
    }
    
    /*
     * Set the message
     */
    protected function setMessage()
    {
        if ( ! isset( $_POST['message'] ) ) {
            $this->error = true;
            $this->data['error']['message'] = 'Please include a message.';
            return;
        }
        
        $this->message = strip_tags( trim( $_POST['message'] ) );
        
        if ( $this->message == '' ) {
            $this->error = true;
            $this->data['error']['message'] = 'Please include a message.';
            return;
        }
        
        $this->data['message'] = $this->message;
    }
    
    /*
     * Send the email
     */
    private function sendContactEmail()
    {
        $config = Config::getInstance();
        
        $email = new ContactEmail;
        $email->setFrom( $config->get('siteemail') );
        $email->setTo( $config->get('siteemail') );
        $email->setName( $this->name );
        $email->setEmail( $this->email );
        $email->setMessage( $this->message );
        $email->setUserAgent( strip_tags( $_SERVER['HTTP_USER_AGENT'] ) );
        $email->setSubject();
        $email->setBody();
        
        return $email->send();
    }
}

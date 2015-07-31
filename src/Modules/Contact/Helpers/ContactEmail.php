<?php
namespace Src\Modules\Contact\Helpers;

use Src\Includes\Email\AdminEmail;

class ContactEmail extends AdminEmail
{
    /*
     * Properties
     */
    protected $name;
    protected $email;
    protected $message;
    protected $user_agent;
    
    /*
     * Setters
     */
    public function setName( $name )
    {
        $this->name = $name;
    }
    public function setEmail( $email )
    {
        $this->email = $email;
    }
    public function setMessage( $message )
    {
        $this->message = $message;
    }
    public function setUserAgent( $ua )
    {
        $this->user_agent = $ua;
    }
    /*
     * Set the to: email
     */
    public function setTo( $email )
    {
        $this->to = $email;
    }
    /*
     * Set the subject
     */
    public function setSubject()
    {
        $this->subject = "Yogi Timer Contact";
    }
    /*
     * Set the body
     */
    public function setBody()
    {
        $to = $this->cleanEmail( $this->to );
        $to = urlencode( $to );
        
        $body = '';
        
        $body .= "Name:\n\n$this->name\n\n";
        $body .= "Email Address:\n\n$this->email\n\n";
        $body .= "Message:\n\n$this->message\n\n";
        $body .= "User Agent:\n\n$this->user_agent";
        
        $this->body = $body;
    }
}

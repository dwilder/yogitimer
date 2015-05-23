<?php
namespace Src\Modules\SignUp\Helpers;

use Src\Includes\Email\AdminEmail;

class VerificationEmail extends AdminEmail
{
    /*
     * Site url
     */
    private $url;
    /*
     * Activation code
     */
    private $activation_key;

    /*
     * Set activation key
     */
    public function setKey( $key )
    {
        $this->activation_key = $key;
    }
    /*
     * Set base url
     */
    public function setUrl( $url )
    {
        $this->url = $url;
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
        $this->subject = "Confirm Your Email Address";
    }
    /*
     * Set the body
     */
    public function setBody()
    {
        $to = $this->cleanEmail( $this->to );
        $to = urlencode( $to );
        
        $body = '';
        
        $body .= "Hey there,\n\n";
        $body .= "Thank you for registering to meditate.\n\n";
        $body .= "Please confirm your email address and activate your account by clicking the link:\n";
        $body .= "https://$this->url/activate/";
        $body .= $to . '/' . $this->activation_key;
        $body .= "\n\nHappy meditating";
        
        $this->body = $body;
    }
}

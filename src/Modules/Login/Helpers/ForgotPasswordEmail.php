<?php
namespace Src\Modules\Login\Helpers;

use Src\Includes\Email\AdminEmail;

class ForgotPasswordEmail extends AdminEmail
{
    /*
     * Site url
     */
    private $url;
    
    /*
     * Store the token value
     */
    private $token = null;
    
    /*
     * Set the token
     */
    public function setToken( $token )
    {
        $this->token = $token;
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
        $this->subject = "Reset Your Password";
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
        $body .= "We received a request to change your password. Just click the link below and create your new password:\n\n";
        $body .= "https://$this->url/resetpassword/";
        $body .= $to . '/' . $this->token;
        $body .= "\n\nIf this wasn't you, you can safely ignore this email.";
        $body .= "\n\nHappy meditating";
        
        $this->body = $body;
    }
}

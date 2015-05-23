<?php
namespace Src\Includes\Email;

/*
 * This is a base class for sending email
 */
class Email
{
    /*
     * Data
     */
    protected $subject;
    protected $body;
    protected $to;
    protected $from;
    
    /*
     * Set data
     */
    public function subject( $value = null )
    {
        $this->subject = $value;
    }
    public function body( $value = null )
    {
        $this->body = $value;
    }
    public function to( $value = null )
    {
        $this->to = $this->cleanEmail( $value );
    }
    public function from( $value = null )
    {
        $this->from = $this->cleanEmail( $value );
    }
    
    /*
     * Clean emails
     */
    protected function cleanEmail( $email )
    {
        return filter_var( $email, FILTER_SANITIZE_EMAIL );
    }
    
    /*
     * Send mail
     */
    public function send()
    {
        if ( $this->subject
            && $this->body
            && $this->cleanEmail( $this->to )
            && $this->from
        ) {
            $success = mail( $this->cleanEmail( $this->to ), $this->subject, $this->body, 'From: ' . $this->from );
            //echo $success;
            //echo '<p>To: ' . $this->to . '</p><p>From: ' . $this->from . '</p><p>' . $this->subject . '</p><p>' . $this->body . '</p>';
            //exit('Sent mail');
            return true;
        }
        return false;
    }
}

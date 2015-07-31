<?php
namespace Src\Modules\SignUp\Helpers;

use Src\Includes\Email\AdminEmail;
use Src\Config\Config;

class AdminNotificationEmail extends AdminEmail
{
    /*
     * Variables
     */
    protected $to;
    protected $subject = null;
    protected $body = null;
    protected $from;
    protected $replyto;
    protected $xmailer;
    protected $html;
    
    /*
     * Constructor (set null)
     */
    public function __construct()
    {
        $this->to = null;
        $this->xmailer = 'PHP/' . phpversion();
        $this->html = false;
        
        $this->setReplyTo();
    }
    
    /*
     * Set Reply-To
     */
    protected function setReplyTo( $replyto = null )
    {
        $this->replyto = $replyto;
    }
    
    /*
     * Set the to: email
     */
    public function setTo()
    {
        $config = Config::getInstance();
        $this->to = $config->get('siteemail');
    }
    /*
     * Set the subject
     */
    public function setSubject()
    {
        $this->subject = "New Member";
    }
    /*
     * Set the body
     */
    public function setBody()
    {
        $body = '';
        
        $body .= "Hey there,\n\n";
        $body .= "Someone new has signed up to meditate.";
        $body .= "\n\nYour friendly server robots";
        
        $this->body = $body;
    }
    
    /*
     * Send
     */
    public function send()
    {
        if ( ! $this->to ) {
            $this->setTo();
        }
        
        if ( ! $this->body ) {
            $this->setBody();
        }
        
        if ( ! $this->subject ) {
            $this->setSubject();
        }
        
        $headers = $this->getHeaders();
        mail( $this->to, $this->subject, $this->body, $headers );
    }
    
    /*
     * Construct email header
     */
    protected function getHeaders()
    {
        $headers = '';
        if ( $this->html ) {
            $headers  .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        }
        $headers .= ($this->from) ? 'From: ' . $this->from . "\r\n" : '';
        $headers .= ($this->replyto) ? 'Reply-To: ' . $this->replyto . "\r\n" : '';
        $headers .= 'X-Mailer: ' . $this->xmailer;
        
        return $headers;
    }
}

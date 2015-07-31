<?php
namespace Src\Includes\Session;

use Src\Includes\Session\Session;

class SessionMessage
{
    /*
     * Properties
     */
    private $source = null;
    private $destination = null;
    private $message = null;
    private $meta = array();
    
    /*
     * Getters and setters
     */
    public function setSource( $source )
    {
        $this->source = $source;
    }
    public function getSource()
    {
        return $this->source;
    }
    public function setDestination( $destination )
    {
        $this->destination = $destination;
    }
    public function getDestination()
    {
        return $this->destination;
    }
    public function setMessage( $message )
    {
        $this->message = $message;
    }
    public function getMessage()
    {
        return $this->message;
    }
    public function setMeta( $meta )
    {
        $this->meta = $meta;
    }
    public function getMeta()
    {
        return $this->meta;
    }
    
    /*
     * Set the message
     */
    public function store()
    {
        $session = Session::getInstance();
        
        $message = array(
            'source' => $this->source,
            'destination' => $this->destination,
            'message' => $this->message,
            'meta' => $this->meta
        );
        
        $session->set( 'session_message', serialize( $message ) );
    }
    
    /*
     * Retrieve a message
     */
    public function retrieve()
    {
        $session = Session::getInstance();
        
        $message = $session->get( 'session_message');
        
        if ( $message ) {
            $message = unserialize( $message );
            
            $this->source = $message['source'];
            $this->destination = $message['destination'];
            $this->message = $message['message'];
            $this->meta = $message['meta'];
            
            return true;
        }
        return false;
    }
    
    /*
     * Delete a session message
     */
    public function delete()
    {
        $session = Session::getInstance();
        $session->set( 'session_message', null );
    }
}
